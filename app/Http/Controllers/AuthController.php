<?php
namespace App\Http\Controllers;

use App\Http\Requests\API\AddFriendRequest;
use App\Http\Requests\API\AddressRequest;
use App\Http\Requests\API\ConfirmUserRequest;
use App\Http\Requests\API\MakeReservationRequest;
use App\Http\Requests\API\NewsletterRequest;
use App\Http\Requests\API\PasswordRequest;
use App\Http\Requests\API\ReviewRequest;
use App\Http\Requests\API\UserRequest;
use App\Http\Resources\AddressResource;
use App\Http\Resources\ChallengeResource;
use App\Http\Resources\ConfirmResource;
use App\Http\Resources\EventResource;
use App\Http\Resources\GiftResource;
use App\Http\Resources\MakeReservationResource;
use App\Http\Resources\NewsletterResource;
use App\Http\Resources\ReservationResource;
use App\Http\Resources\ReviewResource;
use App\Http\Resources\UserResource;
use App\Http\Resources\VoucherResource;
use App\Http\Resources\WishlistResource;
use App\Models\AddFriend;
use App\Models\Address;
use App\Models\Challenge;
use App\Models\ChallengeUser;
use App\Models\ConfirmUser;
use App\Models\Debit;
use App\Models\EventUser;
use App\Models\Hangout;
use App\Models\MakeReservation;
use App\Models\Newsletter;
use App\Models\Reservationmeal;
use App\Models\ReservationMembers;
use App\Models\ReservationTable;
use App\Models\Review;
use App\Models\Slot;
use App\Models\Table;
use App\Models\TablesNumber;
use App\Models\User;
use App\Models\Wishlist;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Validator;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Services\MailService;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth:api', ['except' => ['login', 'register','checkToken','updateCharge']]);
    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    // Use 'admin-api' guard for JWT
    if (!$token = auth('admin-api')->attempt($validator->validated())) {
        return response()->json(['error' => 'Unauthorized'], 401);
    }

    return $this->createNewToken($token);
}


    /**
     * Register a User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request) {

        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|between:2,100',
                'email' => 'required|string|email|max:100|unique:users',
                'username' => 'required|string|max:100|unique:users',
                'phone' => 'nullable|numeric|unique:users',
                'instagramURL' => 'nullable|url',
                'facebookURL' => 'nullable|url',
                'linkedinURL' => 'nullable|url',
                'password' => 'required|string|confirmed|min:6',
            ]);
            if($validator->fails()){
                return response()->json($validator->errors()->toJson(), 400);
            }
            $data = User::create(array_merge(
                        $validator->validated(),
                        ['password' => bcrypt($request->password),
                        ]
                    ));
            $data->otp = generateUniqueOTP();
            $data->save();                    
      
            App::setLocale('en');
            $to = $data->email;
            $toName = $data->name;
            $subject="Your Verification Code";
            $body = view('mail.verification', compact('data'))->render();
             
            // Call the MailService to send the email
            $result = MailService::sendMail($to, $toName, $subject, $body);
            App::setLocale(config('app.locale'));
            
            return response()->json([
                'message' => 'User successfully registered',
                'user' => $data
            ], 201);
        }catch(Ecxception $e){
            dd($e->getMessage());
        }
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        auth('api')->logout();
        return response()->json(['message' => 'User successfully signed out']);
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->createNewToken(auth('admin_api')->refresh());
    }

    public function checkToken(Request $request)
    {
        // Check if the token is still valid
        if (auth('api')->user()) {
            // Optional: Return new token or some response confirming validity
            return response()->json(['isValid' => true], 200);
        } else {
            return response()->json(['isValid' => false], 401);
        }
    }
    
    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function userProfile() {
        return response()->json(auth('api')->user());
    }
    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
protected function createNewToken($token)
{
    return response()->json([
        'access_token' => $token,
        'token_type' => 'bearer',
        'expires_in' => auth('admin-api')->factory()->getTTL() *60*60* 60*60,
        'user' => auth('admin-api')->user(),
    ]);
}


    public function updateUser(UserRequest $request){
        try {
            $input = $request->all();
            $user = User::find(auth()->id()); // مش لازم 'web' لأن `auth()->id()` تجيب الـ ID مباشرة
        
            // تخزين القيم القديمة قبل التعديل
            $oldUser = $user->getOriginal();
        
            // تحديث القيم بدون حفظ
            $user->fill($input);
        
            // التحقق من وجود تغييرات
            if ($user->isDirty()) { 
                // جلب القيم اللي اتغيرت
                $changes = $user->getDirty();
                $changesFormatted = [];
        
                foreach ($changes as $key => $newValue) {
                    $changesFormatted[$key] = [
                        'old' => $oldUser[$key] ?? 'N/A',
                        'new' => $newValue
                    ];
                }
        
                // حفظ التغييرات
                $user->save();
                $user->updateFile(); // تحديث الملفات لو فيه
        
                // إرسال الميل فقط لو فيه تغييرات فعلًا
                if (!empty($changesFormatted)) {
               
                    App::setLocale('en');
                    $to = $user->email;
                    $toName = $user->name;
                    $subject = "Account Update Confirmation";
                    $body = view('mail.changesNotification', compact('user', 'changesFormatted'));
        
                    MailService::sendMail($to, $toName, $subject, $body);
                    App::setLocale(config('app.locale'));
                }
            }
        
            $data['user'] = new UserResource($user);
            return successResponse($data);
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
        
        
    }
    public function insertAddress(AddressRequest $request){
        try {


            $input=$request->all();
            $input['user_id']=auth()->user('web')->id;
            $address = Address::create($input);

            $data['address'] = new AddressResource($address);
            return successResponse($data);
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }


    public function updateAddress(AddressRequest $request,$id){
        try {
            $input=$request->all();
            $address = Address::find($id);
            $address->update($input);
            $data['address'] = new AddressResource($address);
            return successResponse($data);
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }
    public function deleteAddress($id){
        try {
            $address = Address::find($id);
            $address->delete();
            return successResponse('deleted_successfully');
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    public function userPassword(Request $request)
    {
                // Validation rules
            $validator = Validator::make($request->all(), [
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:6',
                'confirm_password' => 'required|string|same:new_password',
            ]);

            // Check validation errors
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            // Get the authenticated user
            $user = auth()->user();

            // Check if the current password matches the user's password
            if (!Hash::check($request->current_password, $user->password)) {
                return response()->json(['error' => 'Current password is incorrect'], 401);
            }

            // Update the user's password
            $user->password = bcrypt($request->new_password);
            $user->save();

            // Generate a new token
            $token = auth('api')->login($user);

            // Return the new token
            return $this->createNewToken($token);

    }

    public function wishlist(){
        try{
            $data['wishlists'] = WishlistResource::collection(auth()->user('web')->wishlists);
            return successResponse($data);
        } catch (Exception $e)
        {
            return failedResponse($e->getMessage());
        }
    }

    public function UserGifts(){
        try{
            $gifts= GiftResource::collection(auth()->user('web')->gifts()->wherePivot('status', 'pending')->latest()->get());
            return successResponse($gifts);
        } catch (Exception $e)
        {
            return failedResponse($e->getMessage());
        }
    }

    public function UserChallenges(){
        try{
            $challenges= ChallengeResource::collection(auth()->user('web')->challenges);
            return successResponse($challenges);
        } catch (Exception $e)
        {
            return failedResponse($e->getMessage());
        }
    }

    public function UserVouchers(){
        try{
            $Vouchers= VoucherResource::collection(auth()->user('web')->vouchers);
            return successResponse($Vouchers);
        } catch (Exception $e)
        {
            return failedResponse($e->getMessage());
        }
    }
    public function UserConfirms(){
        try{
            $Confirms= ConfirmResource::collection(auth()->user('web')->confirms);
            return successResponse($Confirms);
        } catch (Exception $e)
        {
            return failedResponse($e->getMessage());
        }
    }

    public function AcceptChallenges($id){
        try{
            $challenge= ChallengeUser::where('challenge_id',$id)->where('user_id',auth()->user('web')->id)->first();
            // dd($challenge);
            if ($challenge) {
                $challenge->update([
                    'status' => 'accepted',
                ]);

                // Auth::user()->points += 1;
                // Auth::user()->save();
            } else {
                // Handle the case where the challenge-user record is not found
                return response()->json(['message' => 'Challenge not found for user'], 404);
            }

            return successResponse($challenge);
        } catch (Exception $e)
        {
            return failedResponse($e->getMessage());
        }
    }

    public function reservations(){
        try{
            // dd(auth()->user('web')->makereservations[0]->tables);
            $data['reservations'] = MakeReservationResource::collection(auth()->user('web')->makereservations);
            return successResponse($data);
        } catch (Exception $e)
        {
            return failedResponse($e->getMessage());
        }
    }
    public function reservationShow($id){
        try{
            // dd(auth()->user('web')->makereservations[0]->tables);
            $reservation=MakeReservation::find($id);
            $data['reservations'] = new MakeReservationResource(MakeReservation::find($id));
            return successResponse($data);
        } catch (Exception $e)
        {
            return failedResponse($e->getMessage());
        }
    }

    public function reviews(){
        try{
            // dd(new ReviewResource());
            $data['reviews'] = ReviewResource::collection(auth()->user('web')->reviews);
            return successResponse($data);
        } catch (Exception $e)
        {
            return failedResponse($e->getMessage());
        }
    }

    public function destroyreservations($id){
        try {
            $makeReservation = MakeReservation::find($id);
            $makeReservation->delete();
            return successResponse('deleted_successfully');
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    public function destroyreview($id){
        try {
            $review = Review::find($id);
            $review->delete();
            return successResponse('deleted_successfully');
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }
    public function storereview(ReviewRequest $request)
    {

        try {
            $data=$request->all();
            $data['user_id']=auth()->user('web')->id;
            $review = Review::create($data);
            App::setLocale('en');
            $user=auth()->user('web');
            $to = $user->email;
            $toName = $user->name;
            $subject="Share Your Experience";
            $body = view('mail.feedbackRequest', compact('user'))->render();
             
            // Call the MailService to send the email
            $result = MailService::sendMail($to, $toName, $subject, $body);
            App::setLocale(config('app.locale'));
            
            return successResponse($review);
        } catch (Exception $e) {

            return failedResponse($e->getMessage());
        }
    }
    public function storeconfirms(ConfirmUserRequest $request)
    {

        try {
            $data=$request->all();
            $data['user_id']=auth()->user('web')->id;
            $confirmUser = ConfirmUser::create($data);
            return successResponse($confirmUser);
        } catch (Exception $e) {

            return failedResponse($e->getMessage());
        }
    }

    public function storeaddFriend(AddFriendRequest $request)
    {

        try {
            $data=$request->all();
            $data['usersend_id']=auth()->user('web')->id;
            $addFriend = AddFriend::create($data);
            return successResponse($addFriend);
        } catch (Exception $e) {

            return failedResponse($e->getMessage());
        }
    }

    public function newsletterstore($id)
    {

        try {

            $data['restaurant_id']=$id;
            $data['newsletterEmail']=Auth::user()->email;
            $newsletter = Newsletter::create($data);
            return successResponse($newsletter);
        } catch (Exception $e) {

            return failedResponse($e->getMessage());
        }
    }

    public function newsletterdelete($id)
    {

        try {

            $restaurant_id = $id;
            $email = Auth::user()->email;

            // Find and delete the newsletter entry
            $deletedRows = Newsletter::where('restaurant_id', $restaurant_id)
                                      ->where('newsletterEmail', $email)
                                      ->delete();
            return successResponse(['message' => 'newsletter_entry_deleted_successfully']);
        } catch (Exception $e) {

            return failedResponse($e->getMessage());
        }
    }

    public function getNewsletters()
    {
        try {
            $email = Auth::user()->email;

            // Retrieve the newsletters for the authenticated user
            $newsletters = Newsletter::where('newsletterEmail', $email)->latest()->get();

            if ($newsletters->isEmpty()) {
                return failedResponse('no_newsletters_found_for_this_user');
            }
            else
            {
                $newsletters=NewsletterResource::collection($newsletters);
            }

            return successResponse($newsletters);
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }

    public function updateCharge($id,$paymentType)
    {
        try {
            $reservation=MakeReservation::find($id);
            if($reservation)
            {        
                if (!$reservation) {
                    return response()->json(['error' => 'Reservation not found'], 404);
                }
                
                $amount = $reservation->no_people * $reservation->restaurant->miniCharge;
                $orderId = 'ORDER' . $reservation->id . rand(100, 999);
                
                if ($paymentType === 'card')
                {
                    $response = Http::withBasicAuth('merchant.TESTEGPTEST', 'c622b7e9e550292df400be7d3e846476')
                        ->post('https://test-nbe.gateway.mastercard.com/api/rest/version/100/merchant/TESTEGPTEST/session', [
                            'apiOperation' => 'INITIATE_CHECKOUT',
                            'interaction' => [
                                'operation' => 'PURCHASE',
                                'returnUrl' => url('/api/payment/success'),
                                'cancelUrl' => url('/api/payment/cancel'),
                                'merchant' => ['name' => 'Nbe Test'],
                            ],
                            'order' => [
                                'id' => $orderId,
                                'amount' => $amount,
                                'currency' => 'EGP',
                                'description' => 'Order #' . $orderId,
                            ],
                            'checkoutMode' => 'WEBSITE'
                        ]);
            
                    if ($response->successful()) {
                        $reservation->order_id = $orderId;
                        $reservation->payedCharge=1;
                        $reservation->save();
            
                        return response()->json([
                            'sessionId' => $response->json()['session']['id'],
                            'orderId' => $orderId,
                            'amount' => $amount,
                        ]);
                    }
                }
                elseif(($paymentType === 'wallet'))
                {

                    $userPoints = $reservation->user->points;
                    $pointCost = 1 / settings()->pointCost;
                    
                    $pointsValue = $userPoints * $pointCost;
                    
                    if ($pointsValue >= $amount)
                    {
                
                        // احسب عدد النقاط المطلوب خصمها
                        $pointsToDeduct = ceil($amount / $pointCost);
                
                        // خصم النقاط
                        $reservation->user->points -= $pointsToDeduct;
                        $reservation->user->save();
                
                        $reservation->order_id = $orderId;
                        $reservation->payedCharge=1;
                        $reservation->save();
                    
                    }
                    else 
                    {
                        return  failedResponse('Insufficient wallet points to cover the Reservation total.');
                    }
                }
                else 
                {
                  return failedResponse('Invalid payment type');
                }
                
            }
            
            return successResponse($reservation);
        } catch (Exception $e) {
            return failedResponse($e->getMessage());
        }
    }


    public function makeReservation(Request $request, $restaurant_id)
    {
        DB::beginTransaction();
        try {
            $userId = Auth::user()->id;
    
            // QR Code Reservation
            if ($request->isQrcode) {
                $tableNumber = TablesNumber::findOrFail($request->tableNoId);
    
                // Debugging: Check if tableNumber is found
                if (!$tableNumber) {
                    return failedResponse('Table Number not found!');
         
                }
    
                // Check if table and restaurant are present
                if (!$tableNumber->table) {
                    return failedResponse('Table not found!');
                    
                    
                }
                if (!$tableNumber->table->restaurant) {
                    return failedResponse('Restaurant not found for the table!');
           
                }
    
                // Prepare reservation data
                $data = [
                    'user_id' => $userId,
                    'restaurant_id' => $tableNumber->table->restaurant->id,
                    'no_people' => $tableNumber->table->capacity,
                    'isIndoor' => $tableNumber->table->isIndoor,
                    'isSmoking' => $tableNumber->table->isSmoking,
                    'ispool_view' => $tableNumber->table->ispool_view,
                    'issea_view' => $tableNumber->table->issea_view,
                    'isbar' => $tableNumber->table->isbar,
                    'date' => now()->format('Y-m-d'),
                    'confirm' => 1,
                    'status' => 'reserved',
                ];
    
                // Create the reservation
                $makeReservation = MakeReservation::create($data);
    
                // Check if reservation was created successfully
                if (!$makeReservation) {
                    return failedResponse('Failed to create reservation!');

           
                }
    
                // Find the nearest available slot
                $slot = Slot::find($slot->id);
    
                // Debugging: Check if slot is found
                if (!$slot) {
                    return failedResponse('No available slot found!');

                   
                }
    
                // Create reservation table entry
                ReservationTable::create([
                    "make_reservation_id" => $makeReservation->id,
                    "date" => $data['date'],
                    "table_id" => $tableNumber->table->id,
                    "tableNumber_id" => $tableNumber->id,
                    "slot_id" => $slot->id ?? null,
                ]);
    
                // Update tableNumber to reserved
                $tableNumber->update(['isReserved' => 0]);
            } else {
                // General reservation data
                $data = $request->only(['no_people', 'isIndoor', 'isSmoking', 'ispool_view', 'issea_view', 'isbar']);
                $data['user_id'] = $userId;
                $data['restaurant_id'] = $restaurant_id;
                $data['date'] = $request->date ?? now()->format('Y-m-d');
                $data['sittingTime'] = $request->sittingTime ?? 0;
    
                // Create the reservation
                $makeReservation = MakeReservation::create($data);
                if (!$makeReservation) {
                    return failedResponse('Failed to create reservation!');
                    
      
                }
    
                // Attach services if provided
                if ($makeReservation->services() && $request->has('service_ids')) {
                    $makeReservation->services()->attach($request->service_ids);
                }
    
                // Process table numbers if `tableNoId` is provided
                if ($request->has('tableNoId')) {
                    $tableNumber = TablesNumber::findOrFail($request->tableNoId);
    
                    // Debugging: Check if tableNumber is found
                    if (!$tableNumber) {
                    return failedResponse('Table Number not found!');

   
                    }
    
                    // Check for existing reservation for the same table number
                    $existingReservation = ReservationTable::where('tableNumber_id', $tableNumber->id)
                        ->where('date', $request->date)
                        ->where('slot_id', $request->slot_id)
                        ->exists();
    
                    // Debugging: Check if reservation already exists
                    if ($existingReservation) {
                    return failedResponse('This table is already reserved for the selected time slot!');

              
                    }
    
                    // Update reservation status and create reservation table entry
                    $makeReservation->update(['status' => 'reserved']);
                    ReservationTable::create([
                        "make_reservation_id" => $makeReservation->id,
                        "date" => $data['date'],
                        "table_id" => $tableNumber->table_id,
                        "tableNumber_id" => $tableNumber->id,
                        "slot_id" => $request->slot_id,
                    ]);
    
                    // Update tableNumber to reserved
                    $tableNumber->update(['isReserved' => 0]);
                } else {
                    // Handle reservations for multiple capacities
                    foreach ($request->capacities as $capacity) {
                        $availableTable = Table::where('restaurant_id', $restaurant_id)
                            ->when(isset($data['isIndoor']), function ($query) use ($data) {
                                $query->where('isIndoor', $data['isIndoor']);
                            })
                            ->when(isset($data['isSmoking']), function ($query) use ($data) {
                                $query->where('isSmoking', $data['isSmoking']);
                            })
                            ->when(isset($data['ispool_view']), function ($query) use ($data) {
                                $query->where('ispool_view', $data['ispool_view']);
                            })
                            ->when(isset($data['issea_view']), function ($query) use ($data) {
                                $query->where('issea_view', $data['issea_view']);
                            })
                            ->when(isset($data['isbar']), function ($query) use ($data) {
                                $query->where('isbar', $data['isbar']);
                            })
                            ->with('tableNumbers')
                            ->first();
    
                        // Debugging: Check if availableTable is found
                        if (!$availableTable) {
                            
                            return failedResponse('No available table found!');

                        }
    
                        // Get available table number
                        $tableNumber = $availableTable->tableNumbers->first();
    
                        // Debugging: Check if tableNumber is available
                        if (!$tableNumber) {
                            return failedResponse('No available table number found!');

                        }
    
                        // Update reservation status and create reservation table entry
                        $makeReservation->update(['status' => 'reserved']);
                        ReservationTable::create([
                            "make_reservation_id" => $makeReservation->id,
                            "date" => $data['date'],
                            "table_id" => $availableTable->id,
                            "tableNumber_id" => $tableNumber->id,
                            "slot_id" => $request->slot_id,
                        ]);

                        // Update tableNumber to reserved
                        $tableNumber->update(['isReserved' => 0]);
                    }
                }
            }
    
            // Add debit entry
            // Debit::create([
            //     'amount' => ($makeReservation->total * settings()->order_reservationPer) / 100,
            //     'source' => 'order_reservation',
            //     'credit_id' => 1,
            //     'debit_id' => $userId,
            // ]);
    
            // Generate QR Code
            $this->generateQrCode($makeReservation);
            // Set the recipient, subject, and body
            // $to = $makeReservation->user->email;
            // $toName = $makeReservation->user->name;
            // $subject="Welcome to Reservya";
            // $data=$makeReservation->user;
            // $body = view('mail.reservation', compact('data'))->render();
                
            // // Call the MailService to send the email
            // $result = MailService::sendMail($to, $toName, $subject, $body);
    
            DB::commit();
            return successResponse(new ReservationResource($makeReservation));
        } catch (Exception $e) {
            DB::rollBack();
            return failedResponse($e->getMessage());
        }
    }
    
    
    
    
    /**
     * Generate and save QR code for the reservation.
     */
    private function generateQrCode($makereservation)
    {
        $qrData = "Reservation ID: {$makereservation->id}\n" .
                  "Status: {$makereservation->status}\n" .
                  "Number of People: {$makereservation->no_people}\n" .
                  "Indoor: " . ($makereservation->isIndoor ? 'Yes' : 'No') . "\n" .
                  "Smoking: " . ($makereservation->isSmoking ? 'Yes' : 'No') . "\n" .
                  "Sitting Time: {$makereservation->sittingTime}\n" .
                  "Date: {$makereservation->date}";
    
        foreach ($makereservation->tables as $table) {
            $currentTime = now()->format('h:i A');
    
            $qrData .= "\nReservation Date: {$table->date}\n" .
                       "Capacity: {$table->table->capacity}\n" .
                       "Table Number: {$table->number->number}\n" .
                       "Table Password: {$table->number->password}\n" .
                       "Time: " . ($table->slot->slot ?? $currentTime) . "\n";
        }
    
        $directory = public_path('images/qrcodes');
    
        if (!File::exists($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
    
        $path = "{$directory}/reservation_{$makereservation->id}.png";
        QrCode::format('png')->size(200)->generate($qrData, $path);
        $makereservation->qrcode_path = "images/qrcodes/reservation_{$makereservation->id}.png";
        $makereservation->save();
    }
    

}
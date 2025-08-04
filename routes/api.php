Laravel Backend Part

Route::post('/postFunction', [ActionController::class, 'postFunction']);
Route::get('/getFunction', [ActionController::class, 'getFunction']);

code app\Http\Controllers\API\ActionController.php

use App\Http\Controllers\API\ActionController;

<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\API\MessageRequest;
use App\Models\Message;
use App\Models\Task;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ActionController extends Controller

{
    public function postFunction(Request $request)

    {

        try {
            $action = request()->query('action');

            if($action=="contatus")

            $data = Message::create($request->all());

            return successResponse($data);

        } catch (Exception $e) {
             DB::table('tracks')->insert([ 'dispatch_status' => 'showing data of ' . json_encode($e->getMessage()), 'created_at' => now(), ]);
            return failedResponse($e->getMessage());
        }

    }




    public function getFunction(Request $request)

    {

        try {

            $action = request()->query('action');

            if($action=="getTasks")

            $data = Task::get();

            return successResponse($data);

        } catch (Exception $e) {
             DB::table('tracks')->insert([ 'dispatch_status' => 'showing data of ' . json_encode($e->getMessage()), 'created_at' => now(), ]);
            return failedResponse($e->getMessage());
        }

    }

}


React or ReactNative Frontend Part

import axios from "axios"

import AsyncStorage from '@react-native-async-storage/async-storage';

Post part

const formData = new FormData();

formData.append('name', 'John Doe');

formData.append('file', selectedFile); // if you have a file

axios.post(

  'https://yourdomain.com/public/api/postFunction?action=contatus',

  formData, // send FormData directly

  {

    headers: {
      Authorization: `Bearer ${localStorage.getItem("token")}` // if using ReactNative AsyncStorage.getItem('token')

      'Content-Type': 'multipart/form-data', // important for files

    },

  }

)
.then((res) => {

  console.log('Success', res.data);
})
.catch((err) => {

    alert('Failed to send post Function');
    axios.post('https://yousab-tech.com/workspace/public/api/track', { data: err, label: "postFunction", time: new Date().toISOString(), }).catch((err) => { alert('Failed to send debug log'); });
  console.error(err);
});

Get Part

axios.get('https://yourdomain.com/public/api/getFunction', {
  params: {
    action: 'tasks',

    id: 5,
  },
  headers: {
    Authorization: `Bearer ${localStorage.getItem("token")}`,
  }
})
.then((res) => {
  console.log('Success', res.data);
})
.catch((err) => {
  alert('Failed to send GET request');

    axios.post('https://yousab-tech.com/workspace/public/api/track', { data: err, label: "getFunction", time: new Date().toISOString(), }).catch((err) => { alert('Failed to send debug log'); });
  console.error(err);
});







































V
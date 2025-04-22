<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Video;
use App\Models\Testimonial;
use App\Models\Process;
use App\Models\Gallery;
use App\Models\Team;
use App\Models\Counter;
use App\Models\Faq;
use App\Models\Setting;
use App\Models\Partner;
use Exception;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $service;
    private $testimonial;
    private $team;
    private $process;
    private $counter;
    private $portfolio;
    private $faq;
    // private $settings;
    private $teams;
    private $partners;

    public function __construct(Service $service,Video $video, Testimonial $testimonial, Team $team, Process $process, Counter $counter, Gallery $portfolio,Faq $faq,Team $teams,Partner $partners)
    {
        $this->video = $video;
        $this->service = $service;
        $this->testimonial = $testimonial;
        $this->team = $team;
        $this->process = $process;
        $this->counter = $counter;
        $this->portfolio = $portfolio;
        $this->faq=$faq;
        $this->teams=$teams;
        // $this->settings=$settings;
        $this->partners=$partners;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        try {
            $services = $this->service->get();
            $testimonials = $this->testimonial->get();
            $processes = $this->process->take(9)->latest()->get();
            $teams = $this->team->latest()->get();
            $counters = $this->counter->get();
            $portfolios = $this->portfolio->get();
            $faqs=$this->faq->get();
            // $settings=$this->settings->get();
            $teams=$this->teams->get();
            $partners=$this->partners->get();

            return view('front.index', compact('testimonials', 'services', 'processes', 'portfolios', 'teams', 'counters','faqs','teams','partners'));
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }
    public function videos()
    {
        try {
            $videos = $this->video->get();

            return view('videos', compact( 'videos'));
        } catch (Exception $e) {
            dd($e->getMessage());
            return redirect()->back()->with(['error' => __('general.something_wrong')]);
        }
    }
}

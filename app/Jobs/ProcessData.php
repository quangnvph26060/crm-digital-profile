<?php

namespace App\Jobs;

use App\Imports\InformationVbImport;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Maatwebsite\Excel\Facades\Excel;

// use Maatwebsite\Excel\Facades\Excel;

class ProcessData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
   
     public $filePath;

     /**
      * Create a new job instance.
      *
      * @param string $filePath
      */
     public function __construct($filePath)
     {
         $this->filePath = $filePath;
     }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        try {
            $startTime = now();
            Excel::import(new InformationVbImport, $this->filePath);
            $endTime = now();
            return back()->with('success', 'Dữ liệu import thành công');
            \Log::info("Import thành công: {$this->filePath}. Thời gian thực hiện: " . $startTime->diffInSeconds($endTime) . " giây.");
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            \Log::error("Lỗi dữ liệu không hợp lệ: " . json_encode($e->failures()));
        } catch (\Exception $e) {
            \Log::error("Lỗi không xác định khi import file {$this->filePath}: " . $e->getMessage());
        }
        
    }
    public function retryUntil()
    {
        return now()->addMinutes(10);
    }
}

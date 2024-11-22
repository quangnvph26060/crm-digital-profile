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
            
            // Import file
          //  \Log::info($this->filePath);
           Excel::import(new InformationVbImport, $this->filePath);
       
            $endTime = now();
            \Log::info("Import thành công: {$this->filePath}. Thời gian thực hiện: " . $startTime->diffInSeconds($endTime) . " giây.");
        } catch (\Exception $e) {
            \Log::error("Lỗi khi import file {$this->filePath}: " . $e->getMessage());
        }
    }
}

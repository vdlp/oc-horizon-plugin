<?php

declare(strict_types=1);

namespace Vdlp\Horizon\Updates;

use Illuminate\Database\Schema\Blueprint;
use October\Rain\Database\Updates\Migration;
use Schema;

final class CreateJobBatchesTable extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('job_batches')) {
            return;
        }

        Schema::create('job_batches', static function (Blueprint $table): void {
            $table->string('id')
                ->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->text('failed_job_ids');
            $table->mediumText('options')
                ->nullable();
            $table->integer('cancelled_at')
                ->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')
                ->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_batches');
    }
}

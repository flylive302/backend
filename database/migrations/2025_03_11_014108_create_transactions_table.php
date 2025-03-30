<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('beneficiary_id')->constrained('users')->cascadeOnDelete();
            $table->unsignedBigInteger('transactionable_id')->index();
            $table->string('transactionable_type', 255)->index();
            $table->tinyInteger('currency_type')->unsigned()->default(1)->index();
            $table->mediumInteger('quantity')->unsigned()->default(1);
            $table->decimal('real_value', 16, 4)->default(0);
            $table->decimal('change_in_value', 16, 4)->default(0);
            $table->decimal('before', 16, 4)->default(0);
            $table->decimal('after', 16, 4)->default(0);
            $table->tinyInteger('status')->default(1);

            $table->timestamps();
            $table->index('created_at');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};

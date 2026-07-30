<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->boolean('is_admin')->default(false);
            $table->string('cep', 9)->nullable();
            $table->string('numero')->nullable();
            $table->string('logradouro')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado', 2)->nullable();
            $table->string('complemento')->nullable();
            $table->string('telefone')->nullable();
            $table->date('data_nascimento')->nullable();
            $table->string('cpf')->unique()->nullable();
            $table->decimal('saldo', 10, 2)->default(0);
            $table->string('foto')->nullable();
            $table->foreignId('created_by')->nullable()
                ->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['created_by']);
            $table->dropColumn([
                'is_admin',
                'cep',
                'numero',
                'logradouro',
                'bairro',
                'cidade',
                'estado',
                'complemento',
                'telefone',
                'data_nascimento',
                'cpf',
                'saldo',
                'foto',
                'created_by',
            ]);
        });
    }
};

<?php

namespace LaraAreaSupport\Migrations;

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

abstract class RenameMigration extends \Illuminate\Database\Migrations\Migration
{
    /**
     * @var array
     */
    protected $renameColumns = [];

    /**
     * @var array
     */
    protected $renameTable = [];

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        foreach ($this->renameColumns as $tableName => $columnConfig) {
            Schema::table($tableName, function (Blueprint $table) use ($columnConfig) {
                foreach ($columnConfig as $old => $new) {
                    $table->renameColumn($old, $new);
                }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        foreach ($this->renameColumns as $tableName => $columnConfig) {
            Schema::table($tableName, function (Blueprint $table) use ($columnConfig) {
                foreach ($columnConfig as $old => $new) {
                    $table->renameColumn($new, $old);
                }
            });
        }
    }

}

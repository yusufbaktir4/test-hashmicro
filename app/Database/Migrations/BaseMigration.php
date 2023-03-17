<?php

namespace App\Database\Migrations;

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class BaseMigration extends Migration {

    public function defaultUuid() {
        $dbDefault = config("database.default");
        if (config("database.connections.{$dbDefault}.driver") == 'mysql') {
            return DB::raw('uuid()');
        } else {
            return null;
        }
    }

}

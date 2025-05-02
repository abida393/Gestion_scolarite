<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::unprepared('
        CREATE TRIGGER before_insert_or_update_notes
        BEFORE INSERT ON notes
        FOR EACH ROW
        BEGIN
            DECLARE examens INT;
            SELECT nbre_examen INTO examens FROM matieres WHERE id = NEW.matiere_id;

            IF examens = 1 THEN
                SET NEW.note_finale = NEW.note1;
            ELSEIF examens = 2 THEN
                SET NEW.note_finale = (NEW.note1 + NEW.note2) / 2;
            END IF;
        END;
    ');

        DB::unprepared('
        CREATE TRIGGER before_update_notes
        BEFORE UPDATE ON notes
        FOR EACH ROW
        BEGIN
            DECLARE examens INT;
            SELECT nbre_examen INTO examens FROM matieres WHERE id = NEW.matiere_id;

            IF examens = 1 THEN
                SET NEW.note_finale = NEW.note1;
            ELSEIF examens = 2 THEN
                SET NEW.note_finale = (NEW.note1 + NEW.note2) / 2;
            END IF;
        END;
    ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS before_insert_or_update_notes;');
        DB::unprepared('DROP TRIGGER IF EXISTS before_update_notes;');
    }
};

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
        // Trigger on matieres update
        DB::unprepared('
        CREATE TRIGGER after_update_matiere
        AFTER UPDATE ON matieres
        FOR EACH ROW
        BEGIN
            IF OLD.nbre_examen != NEW.nbre_examen THEN
                UPDATE notes
                SET note_finale = CASE
                    WHEN NEW.nbre_examen = 1 THEN note1
                    WHEN NEW.nbre_examen = 2 THEN (note1 + note2) / 2
                    ELSE note_finale
                END
                WHERE matiere_id = NEW.id;
            END IF;
        END;
    ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS after_update_matiere;');
    }
};

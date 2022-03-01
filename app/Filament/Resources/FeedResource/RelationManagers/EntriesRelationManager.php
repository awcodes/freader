<?php

namespace App\Filament\Resources\FeedResource\RelationManagers;

use Filament\Forms;
use Filament\Tables;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Model;
use App\Filament\Resources\EntryResource;
use Filament\Resources\RelationManagers\HasManyRelationManager;

class EntriesRelationManager extends HasManyRelationManager
{
    protected static string $relationship = 'entries';

    protected static ?string $recordTitleAttribute = 'title';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return EntryResource::table($table);
    }
}

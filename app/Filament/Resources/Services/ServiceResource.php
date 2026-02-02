<?php

namespace App\Filament\Resources\Services;

use App\Filament\Resources\Services\Pages\CreateService;
use App\Filament\Resources\Services\Pages\EditService;
use App\Filament\Resources\Services\Pages\ListServices;
use App\Filament\Resources\Services\Schemas\ServiceForm;
use App\Filament\Resources\Services\Tables\ServicesTable;
use App\Models\Service;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\TextColumn;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ServiceResource extends Resource
{
    protected static ?string $model = Service::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return ServiceForm::configure($schema)
        ->schema([
            Forms\Components\TextInput::make('name')
                ->required()
                ->maxLength(255)
                ->label('Nama Layanan'),

            Forms\Components\TextInput::make('price')
                ->numeric()
                ->prefix('Rp')
                ->required()
                ->label('Harga'),

            Forms\Components\Textarea::make('description')
                ->label('Deskripsi')
                ->columnSpanFull(),
        ]);
    }

    public static function table(Table $table): Table
    {
        return ServicesTable::configure($table)
        ->columns([
            Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
            Tables\Columns\TextColumn::make('price')->money('IDR'),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListServices::route('/'),
            'create' => CreateService::route('/create'),
            'edit' => EditService::route('/{record}/edit'),
        ];
    }
}

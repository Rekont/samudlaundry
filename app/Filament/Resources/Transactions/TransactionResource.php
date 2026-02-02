<?php

namespace App\Filament\Resources\Transactions;

use App\Filament\Resources\Transactions\Pages\CreateTransaction;
use App\Filament\Resources\Transactions\Pages\EditTransaction;
use App\Filament\Resources\Transactions\Pages\ListTransactions;
use App\Filament\Resources\Transactions\Schemas\TransactionForm;
use App\Filament\Resources\Transactions\Tables\TransactionsTable;
use App\Models\Transaction;
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

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    public static function form(Schema $schema): Schema
    {
        return TransactionForm::configure($schema)
        ->schema([
                // Kita buat read-only untuk data penting agar admin tidak asal ubah nominal
                Forms\Components\Select::make('user_id')
                    ->relationship('user', 'name')
                    ->disabled(),
                
                Forms\Components\Select::make('service_id')
                    ->relationship('service', 'name')
                    ->disabled(),

                Forms\Components\TextInput::make('quantity')
                    ->disabled(),

                Forms\Components\TextInput::make('total_price')
                    ->prefix('Rp')
                    ->disabled(),

                // Admin hanya boleh ubah Status
                Forms\Components\Select::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'processing' => 'Sedang Dikerjakan',
                        'completed' => 'Selesai',
                    ])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return TransactionsTable::configure($table)
        ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Customer')
                    ->searchable(),

                Tables\Columns\TextColumn::make('service.name')
                    ->label('Layanan'),

                Tables\Columns\TextColumn::make('total_price')
                    ->money('IDR')
                    ->label('Total Bayar'),

                // Menampilkan apakah dapat diskon atau tidak
                Tables\Columns\TextColumn::make('discount_amount')
                    ->money('IDR')
                    ->label('Diskon')
                    ->color('danger'), 

                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'gray',
                        'processing' => 'warning',
                        'completed' => 'success',
                    }),
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->label('Tanggal'),
            ])
            ->defaultSort('created_at', 'desc'); // Transaksi baru di atas
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
            'index' => ListTransactions::route('/'),
            'create' => CreateTransaction::route('/create'),
            'edit' => EditTransaction::route('/{record}/edit'),
        ];
    }
}

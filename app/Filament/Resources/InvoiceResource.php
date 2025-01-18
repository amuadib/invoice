<?php

namespace App\Filament\Resources;

use App\Filament\Resources\InvoiceResource\Pages;
use App\Filament\Resources\InvoiceResource\RelationManagers;
use App\Models\Client;
use App\Models\Invoice;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Get;

class InvoiceResource extends Resource
{
    protected static ?string $model = Invoice::class;

    protected static ?string $navigationIcon = 'heroicon-o-envelope';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('client_id')
                    ->required()
                    ->relationship(name: 'client', titleAttribute: 'nama')
                    ->getOptionLabelFromRecordUsing(fn(Client $record) => "{$record->nama} - {$record->lembaga}"),
                DatePicker::make('tanggal')
                    ->default(date('Y-m-d'))
                    ->required(),
                Forms\Components\Repeater::make('items')
                    ->schema([
                        TextInput::make('nama')
                            ->required()
                            ->columnSpan(3),
                        TextInput::make('keterangan')
                            ->columnSpan(5),
                        TextInput::make('jumlah')
                            ->default(1)
                            ->numeric()
                            ->required()
                            ->columnSpan(1),
                        TextInput::make('harga')
                            ->prefix('Rp')
                            ->required()
                            ->columnSpan(3),
                    ])
                    ->columns(12)
                    ->required()
                    ->columnSpanFull(),
                Select::make('status')
                    ->default('Unpaid')
                    ->live()
                    ->required()
                    ->options(['Unpaid' => 'Unpaid', 'Paid' => 'Paid']),
                DatePicker::make('tanggal_bayar')
                    ->visible(fn(Get $get): bool => $get('status') == 'Paid'),
                Forms\Components\FileUpload::make('bukti_bayar')
                    ->image()
                    ->downloadable()
                    ->visible(fn(Get $get): bool => $get('status') == 'Paid')
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('keterangan')
                    ->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('tanggal', 'desc')
            ->columns([
                TextColumn::make('client.nama'),
                TextColumn::make('tanggal')
                    ->date('d F Y'),
                TextColumn::make('items')
                    ->state(function (Invoice $record) {
                        $str = '<ol>';
                        foreach ($record->items as $i) {
                            $str .= '<li>' . $i['nama'] . ': ' .
                                $i['jumlah']  . ' x Rp ' . number_format($i['harga'], 0, ',', '.') .
                                ' = ' . ' Rp ' . number_format(($i['harga'] * $i['jumlah']), 0, ',', '.') .
                                '</li>';
                        }
                        $str .= '</ol>';

                        return new \Illuminate\Support\HtmlString($str);
                    }),
                TextColumn::make('total')
                    ->prefix('Rp ')
                    ->numeric(thousandsSeparator: '.'),
                TextColumn::make('status'),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('Cetak')
                    ->color('info')
                    ->icon('heroicon-o-printer')
                    ->url(fn(Invoice $record) => '/cetak/invoice/' . $record->id),
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListInvoices::route('/'),
            'create' => Pages\CreateInvoice::route('/create'),
            'view' => Pages\ViewInvoice::route('/{record}'),
            'edit' => Pages\EditInvoice::route('/{record}/edit'),
        ];
    }
}

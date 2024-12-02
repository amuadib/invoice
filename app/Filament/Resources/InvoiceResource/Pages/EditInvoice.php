<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use App\Models\Invoice;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditInvoice extends EditRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            // Actions\ViewAction::make(),
            // Actions\DeleteAction::make(),
            Actions\Action::make('Cetak')
                ->color('info')
                ->icon('heroicon-o-printer')
                ->url(fn(Invoice $record) => '/cetak/invoice/' . $record->id),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['total'] = 0;
        foreach ($data['items'] as $i) {
            $data['total'] += $i['jumlah'] * $i['harga'];
        }

        return $data;
    }
}

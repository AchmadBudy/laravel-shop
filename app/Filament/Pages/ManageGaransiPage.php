<?php

namespace App\Filament\Pages;

use App\Settings\SinglePageSettings;
use Filament\Forms;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Form;
use Filament\Pages\SettingsPage;

class ManageGaransiPage extends SettingsPage
{
    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static string $settings = SinglePageSettings::class;

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                RichEditor::make('garansi_page')
                    ->disableToolbarButtons([
                        'attachFiles',
                    ])
                    ->columnSpanFull()
            ]);
    }
}

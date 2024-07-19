<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TransactionResource\Pages;
use App\Filament\Resources\TransactionResource\RelationManagers;
use App\Models\Transaction;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\Filter;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Tables\Action\ActiveGroup;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\ToggleButtons;
use Filament\Forms\Set;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Filament\Forms\Components\Card;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\ActionGroup;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\CheckboxColumn;

use Filament\Forms\Components\FileUpload\recorderable ;
use Filament\Tables\Filters\SelectFilter;
use Schema;
use Filament\Forms\Components\Repeater;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Widgets\TableWidget as BaseWidget;
use App\Filament\Resources\OrderResource;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\color;
use Filament\Forms\Components\DatePicker;
use App\Filament\Resources\OrderResource\RelationManagers\AddressRelationManager;
use Filament\Forms\Get;
use Filament\Forms\Components\Textarea;
use Illuminate\Support\Number;
use Filament\Forms\Components\Placeholder;

class TransactionResource extends Resource
{
    protected static ?string $model = Transaction::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
                 Select::make('product_id')
                 ->required()
                 ->searchable()
                 ->preload()
                 ->relationship('Product' , 'products')->columnSpanFull(),


                 TextInput::make('qte')
                 ->required()
                 ->numeric()
                 ->default(1)
                 ->minValue(1)->columnSpanFull(),

                 TextInput::make('raja3t')
                 ->numeric()
                 ->default(0)
                 ->minValue(0)->columnSpanFull(),

                 Group::make()->schema([
                        ToggleButtons::make('li_seleft')
                        ->inline()
                        ->required()
                        ->options([
                            'AM' => 'AM',
                            'DZ' => 'DZ'
                        ])
                        ->colors([
                            'AM' => 'info',
                            'DZ' => 'danger'
                        ]),

                        TextInput::make('li_seleft')
                        ->maxLength(255)
                        ->reactive(),

                        TextInput::make('el_mostafid')
                        ->maxLength(255)
                        ->disabled(fn ($get) => $get('li_seleft') === null),
                ])->columns(3),

                    TextInput::make('note')
                        ->maxLength(255)->columnSpanFull(),

        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('created_at')
                ->dateTime('d/m/Y')
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: false),

                Tables\Columns\TextColumn::make('Product.products')
                ->searchable()
                ->badge()
                ->color('success')
                ->sortable(),


                Tables\Columns\TextColumn::make('li_seleft')
                ->searchable()
                ->badge()
                ->color(fn (string $state): string => match($state) {
                    'AM' => 'info',
                    'DZ' => 'danger',
                    default => 'primary', // Replace with your default color
                })
                ->sortable(),

            Tables\Columns\TextColumn::make('el_mostafid')
                ->searchable()
                ->badge()
                ->color(fn (string $state): string => match($state) {
                    'AM' => 'info',
                    'DZ' => 'danger',
                    default => 'primary', // Replace with your default color
                })
                ->sortable(),


                Tables\Columns\TextColumn::make('qte')
                ->numeric()
                ->badge()
                ->sortable(),

                Tables\Columns\TextColumn::make('raja3t')
                ->numeric()
                ->badge()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('rest')
                ->label('REST')
                ->numeric()
                ->badge()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),


                Tables\Columns\TextColumn::make('note')
                ->searchable()
                ->sortable()
                ->words(2),



                CheckboxColumn::make('ok')
                ->label('C Bon')
                ->afterStateUpdated(function ($state, $record) {
                    Log::info('State updated', ['state' => $state, 'record' => $record]);

                    if ($state) {
                        $record->rest = 0;
                        $record->raja3t = $record->qte;
                    } else {
                        $record->raja3t = $record->previousRaja3t;
                    }

                    $record->save();
                })
                ->default(fn ($record) => $record->rest === 0)
                ->sortable(),


                Tables\Columns\TextColumn::make('updated_at')
                ->dateTime()
                ->sortable()
                ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                SelectFilter::make('Product')
                   ->relationship('Product' , 'products'),

                   Filter::make('created_at')
            ->form([
                DatePicker::make('created_from'),
                DatePicker::make('created_until'),
    ])

            ])

            ->actions([
                ViewAction::make()
                ->color('info'),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getNavigationBadge(): ? string{
        return static::getModel()::count();
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTransactions::route('/'),
            'create' => Pages\CreateTransaction::route('/create'),
            'edit' => Pages\EditTransaction::route('/{record}/edit'),
        ];
    }
}

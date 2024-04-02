<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AccountResource\Pages;
use App\Models\Account;
use App\Models\Collection;
use Filament\Forms;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Exists;

class AccountResource extends Resource
{
    protected static ?string $model = Account::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function table(Table $table): Table
    {
        //        ray()->showQueries();

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name'),
                Tables\Columns\IconColumn::make('active')->boolean()->alignCenter(),
                Tables\Columns\TextColumn::make('address')->limit(20),
                Tables\Columns\TextColumn::make('city'),
                Tables\Columns\TextColumn::make('state'),
                Tables\Columns\TextColumn::make('country')->limit(20),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\Action::make('collections')
                    ->label('Collections')
                    ->slideOver()
                    ->fillForm(
                        fn (Account $record): array => $record->collections()
                            ->ownedByCurrentUser()
                            ->get()
                            ->all()
                    )
                    ->form([
                        Forms\Components\CheckboxList::make('id')
                            ->label('Collections')
                            ->searchable()
                            ->relationship(
                                'collections',
                                'name',
                                fn (Builder $query): Builder => $query->ownedByCurrentUser()
                            )
                            ->exists(
                                Collection::class,
                                'id',
                                fn (Exists $rule): Exists => $rule->where(
                                    'user_id',
                                    Auth::user()->id
                                )
                            ),
                    ])
                    ->after(fn () => Notification::make()->success()->title('Saved')->send()),
            ])
            ->bulkActions([
                //
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAccounts::route('/'),
        ];
    }
}

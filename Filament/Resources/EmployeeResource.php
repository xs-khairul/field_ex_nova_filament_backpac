<?php

namespace App\Filament\Resources;

use Filament\Forms;
use App\Models\City;
use Filament\Tables;
use App\Models\State;
use App\Models\Country;
use App\Models\Employee;
use Filament\Resources\Form;
use Filament\Resources\Table;
use Filament\Resources\Resource;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\DatePicker;
use Illuminate\Database\Eloquent\Builder;
use App\Filament\Resources\EmployeeResource\Pages;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\EmployeeResource\RelationManagers;

class EmployeeResource extends Resource
{
    protected static ?string $model = Employee::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';
    protected static ?string $navigationGroup = 'Employee Management';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Card::make()->schema([
                    Select::make('country_id')
                            ->label('Country')
                            ->options(Country::all()->pluck('name', 'id')->toArray())
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set) => $set('state_id', null)),
                    Select::make('state_id')
                            ->label('State')
                            ->options(function(callable $get){
                                $country = Country::find($get('country_id'));
                                if(!$country) {
                                    return State::all()->pluck('name', 'id');
                                }
                                return $country->states->pluck('name', 'id');
                            })
                            ->reactive()
                            ->afterStateUpdated(fn (callable $set) => $set('city_id', null)),
                    Select::make('city_id')
                            ->label('City')
                            ->options(function(callable $get){
                                $state = State::find($get('state_id'));
                                if(!$state) {
                                    return City::all()->pluck('name', 'id');
                                }
                                return $state->cities->pluck('name', 'id');
                            }),
                    Select::make('department_id')->relationship('department', 'name'),
                    Forms\Components\TextInput::make('first_name'),
                    Forms\Components\TextInput::make('last_name'),
                    Forms\Components\TextInput::make('zip_code'),
                    DatePicker::make('birth_date'),
                    DatePicker::make('date_hired'),
                ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('country.name')->sortable(),
                Tables\Columns\TextColumn::make('state.name')->sortable(),
                Tables\Columns\TextColumn::make('city.name')->sortable(),
                Tables\Columns\TextColumn::make('department.name')->sortable(),
                Tables\Columns\TextColumn::make('first_name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('last_name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('zip_code')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('birth_date')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('date_hired')->sortable()->searchable(),
            ])
            ->filters([
                Tables\Filters\Filter::make('first_name')->query(fn (Builder $query): Builder => $query->whereNotNull('first_name')),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                Tables\Actions\ForceDeleteBulkAction::make(),
                Tables\Actions\RestoreBulkAction::make(),
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
            'index' => Pages\ListEmployees::route('/'),
            'create' => Pages\CreateEmployee::route('/create'),
            'edit' => Pages\EditEmployee::route('/{record}/edit'),
        ];
    }    
    
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}

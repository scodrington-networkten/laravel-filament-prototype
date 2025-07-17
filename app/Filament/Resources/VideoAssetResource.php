<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VideoAssetResource\Pages;
use App\Filament\Resources\VideoAssetResource\RelationManagers;
use App\Models\VideoAsset;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\DatePicker;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;

class VideoAssetResource extends Resource
{
    protected static ?string $model = VideoAsset::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('title')
                         ->placeholder('Asset title')
                         ->required(),
                Textarea::make('description')
                        ->placeholder('Asset description')
                        ->required(),
                Section::make('Availability')
                       ->description('Start / End Availablity dates')
                       ->schema([
                           Grid::make(2)
                               ->schema([
                                   self::getDateField('Media Availability Date', 'media_available_date'),
                                   self::getDateField('Media Expiration Date', 'media_expiration_date'),
                               ])
                       ]),
                TextInput::make('guid')
                         ->label('GUID')
                         ->readOnly()
                         ->helperText('Unique asset ID')
                         ->default(function () {
                             /**
                              * Generate a GUID on creation
                              *
                              * @todo compare guid acrosss all models that implement the 'HasGuid' trait to ensure
                              *       correct generation of UID uniqueness
                              */
                             $uid   = Str::uuid()->toString();
                             $match = VideoAsset::where('guid', $uid)->first();
                             if ($match) {
                                 error_log('guid already matched an existing asset');
                             }

                             return $uid;
                         }),
                self::getMediaRatingsField(),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                //
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListVideoAssets::route('/'),
            'create' => Pages\CreateVideoAsset::route('/create'),
            'edit'   => Pages\EditVideoAsset::route('/{record}/edit'),
        ];
    }

    protected static function getDateField(string $name, string $keyname): DatePicker
    {
        return DatePicker::make($keyname)
                         ->Label($name)
                         ->required()
                         ->default(function ($record) {
                             if ($record && $record->{$keyname}) {
                                 return Carbon::createFromTimestamp($record->{$keyname})->toDateString();
                             } else {
                                 return Carbon::now()->toDateString();
                             }
                         })
                         ->dehydrateStateUsing(function ($state) {
                             return ($state) ? Carbon::createFromTimestamp($state)->timestamp : null;
                         });
    }

    /**
     * Returns a repeater of media ratings for the asset
     *
     * @return Repeater $field
     */
    protected static function getMediaRatingsField(): Repeater
    {
        $field = Repeater::make('media_ratings')
                         ->label('Media Ratings')
                         ->addActionLabel('Add a Media Rating')
                         ->schema([
                             //The top level rating (based on the scheme?)
                             Select::make('rating')
                                   ->label('Rating')
                                   ->options([
                                       'G'     => 'G',
                                       'PG'    => 'PG',
                                       'M'     => 'M',
                                       'MA15+' => 'MA15+',
                                       'R18+'  => 'R18+',
                                   ])
                                   ->required(),
                             //The schema itself (hard coded to just be au TV for now)
                             TextInput::make('scheme')
                                      ->label('Scheme')
                                      ->required()
                                      ->default('urn:www.acma.gov.au:tv')
                                      ->helperText('The scheme that this rating is associated with'),

                             //Repeater of sub themes (classificatins)
                             Repeater::make('sub_ratings')
                                     ->label('Sub Ratings')
                                     ->addActionLabel('Add a Sub Rating')
                                     ->schema([
                                         Select::make('sub_rating')
                                               ->label('Sub Rating')
                                               ->options([
                                                   "mild_themes"                 => 'Mild Thematic Elements',
                                                   "moderate_themes"             => 'Moderate Thematic Elements',
                                                   "strong_themes"               => 'Strong Thematic Elements',
                                                   "violence_themes"             => 'Violence Themes',
                                                   "suicide_themes"              => 'Suicide Themes',
                                                   "drug_references"             => 'Drug References',
                                                   "drug_use"                    => 'Drug Use',
                                                   "nudity_themes"               => 'Nudity Themes',
                                                   "sexual_themes"               => 'Sexual Themes',
                                                   "coarse_language_themes"      => 'Coarse Language Themes',
                                                   "horror_themes"               => 'Horror Themes',
                                                   "gambling_themes"             => 'Gambling Themes',
                                                   "dangerous_imitable_activity" => 'Dangerous Imitable Activity',
                                                   "brief_nudity"                => 'Brief Nudity', // Added a specific sub-rating
                                                   "implied_nudity"              => 'Implied Nudity', // Added a specific sub-rating
                                                   "sexual_references"           => 'Sexual References', // Added a specific sub-rating
                                                   "mild_violence"               => 'Mild Violence', // Added a specific sub-rating
                                                   "moderate_violence"           => 'Moderate Violence', // Added a specific sub-rating
                                                   "strong_violence"             => 'Strong Violence', // Added a specific sub-rating
                                                   "mild_coarse_language"        => 'Mild Coarse Language', // Added a specific sub-rating
                                                   "moderate_coarse_language"    => 'Moderate Coarse Language', // Added a specific sub-rating
                                                   "strong_language"             => 'Strong Language' // Added a specific sub-rating
                                               ])
                                     ])

                         ]);

        return $field;
    }
}

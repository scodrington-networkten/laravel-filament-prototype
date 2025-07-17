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
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;

class VideoAssetResource extends Resource
{
    protected static ?string $model = VideoAsset::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Form Tabs')
                    //->vertical() (this uses a package to create vertcal tabs, generates alpine error)
                    ->tabs([
                        Tab::make('Primary')
                           ->icon('heroicon-o-cog')
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
                                        })
                           ]),
                        Tab::make('Secondary')
                           ->icon('heroicon-o-bell')
                           ->schema([
                               self::getMediaRatingsField(),
                               Checkbox::make('Pl Media Approved')
                                       ->label('Pl Media Approved')
                                       ->default(false),
                               self::getChaptersField()
                           ])
                    ])
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
                         ->label($name)
                         ->required()
                         ->default(function ($record) use ($keyname) {
                             if ($record && $record->{$keyname}) {
                                 return Carbon::createFromTimestamp($record->{$keyname})->toDateString();
                             }
                             return Carbon::now()->toDateString();
                         })
                         ->formatStateUsing(function ($state) {
                             if (!$state) {
                                 return null;
                             }
                             // If $state is a numeric timestamp, convert to Y-m-d string
                             if (is_numeric($state)) {
                                 return Carbon::createFromTimestamp($state)->toDateString();
                             }
                             // Otherwise assume already Y-m-d string
                             return $state;
                         })
                         ->dehydrateStateUsing(function ($state) {
                             return $state ? Carbon::parse($state)->timestamp : null;
                         });
    }

    /**
     * Returns a section of media ratings for the asset
     *
     * @return Section
     */
    protected static function getMediaRatingsField(): Section
    {
        return Section::make('Media Ratings')
                      ->label('Media Ratings')
                      ->description('Defines the rating and classifiction infromation for this asset')
                      ->schema([
                          Repeater::make('media_ratings')
                                  ->label('Media Ratings')
                                  ->addActionLabel('Add a Media Rating')
                                  ->default([])
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
                                              ->hint('This is a hint')
                                              ->helperText('These sub-ratings are optional classifications associated with the rating')
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
                                                            "brief_nudity"                => 'Brief Nudity',
                                                            // Added a specific sub-rating
                                                            "implied_nudity"              => 'Implied Nudity',
                                                            // Added a specific sub-rating
                                                            "sexual_references"           => 'Sexual References',
                                                            // Added a specific sub-rating
                                                            "mild_violence"               => 'Mild Violence',
                                                            // Added a specific sub-rating
                                                            "moderate_violence"           => 'Moderate Violence',
                                                            // Added a specific sub-rating
                                                            "strong_violence"             => 'Strong Violence',
                                                            // Added a specific sub-rating
                                                            "mild_coarse_language"        => 'Mild Coarse Language',
                                                            // Added a specific sub-rating
                                                            "moderate_coarse_language"    => 'Moderate Coarse Language',
                                                            // Added a specific sub-rating
                                                            "strong_language"             => 'Strong Language'
                                                            // Added a specific sub-rating
                                                        ])
                                              ])

                                  ])
                      ]);
    }

    /**
     * Returns a repeater to define chapters
     *
     * @return Repeater
     */
    protected static function getChaptersField(): Section
    {
        return Section::make('Chapters')->schema([
            Repeater::make('pl_media_chapters')
                    ->label('Chapters')
                    ->addActionLabel('Add Chapter')
                    ->schema([
                        TextInput::make('start_time')
                                 ->helperText('The start time for this chapter segment')
                                 ->required()->hint('e.g. 453.0'),
                        TextInput::make('title')
                                 ->required()
                    ])
        ])->description('Define a collection of chapters for this asset');
    }

}

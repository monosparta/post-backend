<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Trix;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\MorphOne;
use Laravel\Nova\Fields\BelongsTo;
use Laravel\Nova\Http\Requests\NovaRequest;

class UserProfile extends Resource
{
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = \App\Models\UserProfile::class;

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'last_name';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id', 'last_name', 'nick_name'
    ];

    public static $displayInNavigation = false;

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function fields(NovaRequest $request)
    {
        return [
            BelongsTo::make('User')->readonly(),

            ID::make()->sortable()->hideFromDetail(),

            Text::make('Nick Name'),

            Text::make('First Name')
                ->sortable()
                ->rules('required', 'max:255'),
            
            Text::make('Last Name')
                ->sortable()
                ->rules('required', 'max:255'),
            
            Text::make('Middle Name')
                ->sortable()
                ->rules('required', 'max:255'),
            
            Date::make('Birth Date'),

            Select::make('Gender')->options([
                'female' => 'Female',
                'male' => 'Male ',
                'other' => 'Other',
            ]),

            Text::make('Job Title'),

            Text::make('Phone Country Code'),

            Text::make('Phone Country Calling Code'),

            Text::make('Phone'),

            Text::make('Nationality'),

            Text::make('Identity Code'),

            Trix::make('Note')->hideFromIndex(),

            MorphOne::make('Address'),
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function cards(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function filters(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function lenses(NovaRequest $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
     * @return array
     */
    public function actions(NovaRequest $request)
    {
        return [];
    }
}

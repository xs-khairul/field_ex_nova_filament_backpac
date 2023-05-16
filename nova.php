<?php

##url : https: //nova.laravel.com/docs/4.0/resources/fields.html
####### description on above comment ####### 


use Laravel\Nova\Panel;

/**
 * Get the fields displayed by the resource.
 *
 * @param  \Laravel\Nova\Http\Requests\NovaRequest  $request
 * @return array
 */
function fields(NovaRequest $request)
{
    return [
        ID::make()->sortable(),

        new Panel('Address Information', $this->addressFields()),
    ];
}

/**
 * Get the address fields for the resource.
 *
 * @return array
 */
protected function addressFields()
{
    return [
        Text::make('Address', 'address_line_1')->hideFromIndex(),
        Text::make('Address Line 2')->hideFromIndex(),
        Text::make('City')->hideFromIndex(),
        Text::make('State')->hideFromIndex(),
        Text::make('Postal Code')->hideFromIndex(),
        Country::make('Country')->hideFromIndex(),
    ];
}

Currency::make('Price')->locale('fr'),


Text::make('Name')->required()
    ->suggestions([
        'David Hemphill',
        'Taylor Otwell',
        'James Brooks',
    ]),
Text::make('Name')->maxlength(250)->enforceMaxlength(),

Textarea::make('Excerpt')->withMeta(['extraAttributes' => [
    'placeholder' => 'Make it less than 50 characters']
]),



use Laravel\Nova\Fields\Textarea;

Textarea::make('Name')->maxlength(250)->enforceMaxlength(),
use Laravel\Nova\Fields\Textarea;

Textarea::make('Name')->maxlength(250),





use Laravel\Nova\Fields\File;

File::make('Attachment'),


use Laravel\Nova\Fields\Heading;

Heading::make('Meta'),


Hidden::make('Slug'),

Hidden::make('Slug')->default(Str::random(64)),




use Laravel\Nova\Fields\MultiSelect;

MultiSelect::make('Sizes')->options([
    'S' => 'Small',
    'M' => 'Medium',
    'L' => 'Large',
]),
MultiSelect::make('Size')->options([
    'S' => 'Small',
    'M' => 'Medium',
    'L' => 'Large',
])->displayUsingLabels(),



Number::make('price')->min(1)->max(1000)->step(0.01),
#You may also allow arbitrary-precision decimal values:

Number::make('price')->min(1)->max(1000)->step('any'),




Password::make('Password')
    ->onlyOnForms()
    ->creationRules('required', Rules\Password::defaults(), 'confirmed')
    ->updateRules('nullable', Rules\Password::defaults(), 'confirmed'),

PasswordConfirmation::make('Password Confirmation')




Select::make('Size')->options([
    'MS' => ['label' => 'Small', 'group' => 'Men Sizes'],
    'MM' => ['label' => 'Medium', 'group' => 'Men Sizes'],
    'WS' => ['label' => 'Small', 'group' => 'Women Sizes'],
    'WM' => ['label' => 'Medium', 'group' => 'Women Sizes'],
])->displayUsingLabels(),

Select::make('Size')->options(function () {
    return array_filter([
        Size::SMALL => Size::MAX_SIZE === SIZE_SMALL ? 'Small' : null,
        Size::MEDIUM => Size::MAX_SIZE === SIZE_MEDIUM ? 'Medium' : null,
        Size::LARGE => Size::MAX_SIZE === SIZE_LARGE ? 'Large' : null,
    ]);
}),



/*Customizing KeyValue Labels
You can customize the text values used in the component by calling the keyLabel, valueLabel, and actionText methods when defining the field. The actionText method customizes the "add row"
*/
KeyValue::make('Meta')
    ->keyLabel('Item')
    ->valueLabel('Label')
    ->actionText('Add Item'),

KeyValue::make('Meta')->disableEditingKeys(),


KeyValue::make('Meta')->disableAddingRows(),
KeyValue::make('Meta')->disableDeletingRows(),


// Using an array...
Sparkline::make('Post Views')->data([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]),

// Using a callable...
Sparkline::make('Post Views')->data(function () {
    return json_decode($this->views_data);
}),





/*
The loadingWhen and failedWhen methods may be used to instruct the field which words indicate a "loading" state and which words indicate a "failed" state. In this example, we will indicate that database column values of waiting or running should display a "loading" indicator:
*/
Status::make('Status')
    ->loadingWhen(['waiting', 'running'])
    ->failedWhen(['failed']),



/*Passing Closures to Line Fields
In addition to passing BelongsTo, Text, and Line fields to the Stack field, you may also pass a closure. The result of the closure will automatically be converted to a Line instance:*/
Stack::make('Details', [
    Line::make('Name')->asHeading(),
    fn () => optional($this->resource)->position
]),

/*In addition to the Line field's presentational methods, you may also pass any additional Tailwind classes to the field to customize the appearance of the Line:*/
Stack::make('Details', [
    Line::make('Title')->extraClasses('italic font-medium text-80'),
]),


// Can be "sm", "md", "lg", "xl", "2xl", "3xl", "4xl", "5xl", "6xl", "7xl".
Tag::make('Tags')->showCreateRelationButton()->modalSize('7xl'),
use Laravel\Nova\Fields\Tag;

Tag::make('Tags')->showCreateRelationButton(),




Trix::make('Biography')->alwaysShow(),
use Laravel\Nova\Fields\Trix;
Trix::make('Biography')->alwaysShow(),

Trix::make('Biography')->withFiles('public'),


use Laravel\Nova\Fields\UiAvatar;

// Using the "name" column...
UiAvatar::make(),

// Using a custom column...
UiAvatar::make('Avatar', 'full_name'),


URL::make('GitHub URL'),

use Laravel\Nova\Fields\VaporFile;

VaporFile::make('Document')

use Laravel\Nova\Fields\VaporImage;

VaporImage::make('Avatar'),
#Validating Vapor Image / File Fields
use Illuminate\Support\Facades\Storage;

VaporFile::make('Document')
    ->rules('bail', 'required', function ($attribute, $value, $fail) use ($request) {
        if (Storage::size($request->input('vaporFile')[$attribute]['key']) > 1000000) {
            return $fail('The document size may not be greater than 1 MB');
        }
    }),

    
#Computed Fields
Text::make('Name', function () {
    return $this->first_name.' '.$this->last_name;
}),


Text::make('Email')->rules('required');
Text::make('Email')->readonly(function ($request) {
    return ! $request->user()->isAdmin();
}),


##Dependent Fields
use Laravel\Nova\Fields\FormData;
use Laravel\Nova\Fields\Select;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Http\Requests\NovaRequest;

Select::make('Purchase Type', 'type')
    ->options([
        'personal' => 'Personal',
        'gift' => 'Gift',
    ]),

// Recipient field configuration is customized based on purchase type...
Text::make('Recipient')
    ->readonly()
    ->dependsOn(
        ['type'],
        function (Text $field, NovaRequest $request, FormData $formData) {
            if ($formData->type === 'gift') {
                $field->readonly(false)->rules(['required', 'email']);
            }
        }
    ),


?>
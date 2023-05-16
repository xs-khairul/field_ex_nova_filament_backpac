<?php

#url : https://filamentphp.com/docs/2.x/forms/fields

use Filament\Forms\Components\TextInput;
 
TextInput::make('name');
TextInput::make('name')->label(__('fields.name'));
TextInput::make('name')->translateLabel();// Equivalent to `label(__('Name'))`
TextInput::make('name')->id('name-field');#Setting an ID
TextInput::make('name')->default('John');#Setting a default value
TextInput::make('name')->helperText('Your full name here, including any middle names.');#Helper messages and hints
TextInput::make('password')->hint('[Forgotten your password?](forgotten-password)');#hints
TextInput::make('name')->extraAttributes(['title' => 'Text input']); # custom attribute
TextInput::make('name')->disabled() ;#disabled
TextInput::make('name')->hidden();#hiding
TextInput::make('name')->hidden(! auth()->user()->isAdmin());#optional hiding
TextInput::make('name')->autofocus();#Autofocusing

TextInput::make('name')->placeholder('John Doe');#Setting a placeholder
TextInput::make('text')
    ->email()
    ->numeric()
    ->password()
    ->tel()
    ->url(); # validation fn

TextInput::make('name')
    ->minLength(2)
    ->maxLength(255); # min max 

TextInput::make('password')
    ->password()
    ->disableAutocomplete();#  disableAutocomplete
TextInput::make('phone')
    ->tel()
    ->telRegex('/^[+]*[(]{0,1}[0-9]{1,4}[)]{0,1}[-\s\.\/0-9]*$/');#Phone number validation
TextInput::make('domain')
    ->url()
    ->prefix('https://')
    ->suffix('.com');# prefix suffix

TextInput::make('domain')
    ->suffixAction(fn (?string $state): Action =>
        Action::make('visit')
            ->icon('heroicon-s-external-link')
            ->url(
                filled($state) ? "https://{$state}" : null,
                shouldOpenInNewTab: true,
            ),
        );#You may render an action before and after the input using the prefixAction() and suffixAction() methods:

TextInput::make('name')
    ->mask(fn (TextInput\Mask $mask) => $mask->pattern('+{7}(000)000-00-00'));#Input masking is the practice of defining a format that the input value must conform to.

TextInput::make('number')
    ->numeric()
    ->mask(fn (TextInput\Mask $mask) => $mask
        ->numeric()
        ->decimalPlaces(2) // Set the number of digits after the decimal point.
        ->decimalSeparator(',') // Add a separator for decimal numbers.
        ->integer() // Disallow decimal numbers.
        ->mapToDecimalSeparator([',']) // Map additional characters to the decimal separator.
        ->minValue(1) // Set the minimum value that the number can be.
        ->maxValue(100) // Set the maximum value that the number can be.
        ->normalizeZeros() // Append or remove zeros at the end of the number.
        ->padFractionalZeros() // Pad zeros at the end of the number to always maintain the maximum number of decimal places.
        ->thousandsSeparator(','), // Add a separator for thousands.
        );
TextInput::make('code')->mask(fn (TextInput\Mask $mask) => $mask
    ->range()
    ->from(1) // Set the lower limit.
    ->to(100) // Set the upper limit.
    ->maxValue(100), // Pad zeros at the start of smaller numbers.
    );


use Filament\Forms\Components\Select;
 
Select::make('status')
    ->options([
        'draft' => 'Draft',
        'reviewing' => 'Reviewing',
        'published' => 'Published',
    ]);

    Select::make('authorId')
    ->label('Author')
    ->options(User::all()->pluck('name', 'id'))
    ->searchable();#You may enable a search input to allow easier access to many options, using the searchable() method:

Select::make('authorId')
    ->searchable()
    ->getSearchResultsUsing(fn (string $search) => User::where('name', 'like', "%{$search}%")->limit(50)->pluck('name', 'id'))
    ->getOptionLabelUsing(fn ($value): ?string => User::find($value)?->name);
Select::make('status')
    ->options([
        'draft' => 'Draft',
        'reviewing' => 'Reviewing',
        'published' => 'Published',
    ])
    ->default('draft')
    ->disablePlaceholderSelection();
    /*
    If you have lots of options and want to populate them based on a database search or other external data source, you can use the getSearchResultsUsing() and getOptionLabelUsing() methods instead of options().

    The getSearchResultsUsing() method accepts a callback that returns search results in $key => $value format.

    The getOptionLabelUsing() method accepts a callback that transforms the selected option $value into a label.
    */

    Select::make('technologies')
    ->multiple()
    ->options([
        'tailwind' => 'Tailwind CSS',
        'alpine' => 'Alpine.js',
        'laravel' => 'Laravel',
        'livewire' => 'Laravel Livewire',
    ]);# multiple
Select::make('authorId')
    ->relationship('author', 'name');#You may employ the relationship() method of the Select to configure a BelongsTo relationship to automatically retrieve and save options from:
Select::make('technologies')
    ->multiple()
    ->relationship('technologies', 'name');#The multiple() method may be used in combination with relationship() to automatically populate from a BelongsToMany relationship:





use Filament\Forms\Components\Toggle;
 
Toggle::make('is_admin')->disabled(! auth()->user()->isAdmin());#Optionally, you may pass a boolean value to control if the field should be disabled or not:
Toggle::make('is_admin');
Toggle::make('is_admin')
    ->onIcon('heroicon-s-lightning-bolt')
    ->offIcon('heroicon-s-user');





use Filament\Forms\Components\RichEditor;
 
RichEditor::make('content')
    ->hint('Translatable')
    ->hintIcon('heroicon-s-translate');#Hints may also have an icon rendered next to them:
RichEditor::make('content')
    ->hint('Translatable')
    ->hintColor('primary');#Hints may have a color(). By default it's gray,


use Filament\Forms\Components\Checkbox;
 
Checkbox::make('is_admin')->inline();
Checkbox::make('is_admin')->inline(false);
use Filament\Forms\Components\CheckboxList;
 
CheckboxList::make('technologies')
    ->options([
        'tailwind' => 'Tailwind CSS',
        'alpine' => 'Alpine.js',
        'laravel' => 'Laravel',
        'livewire' => 'Laravel Livewire',
    ]);



use Filament\Forms\Components\Radio;
 
Radio::make('status')
    ->options([
        'draft' => 'Draft',
        'scheduled' => 'Scheduled',
        'published' => 'Published'
    ])
    ->descriptions([
        'draft' => 'Is not visible.',
        'scheduled' => 'Will be visible.',
        'published' => 'Is visible.'
    ]);

Radio::make('feedback')
    ->label('Do you like this post?')
    ->boolean();


use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\TimePicker;
 
DateTimePicker::make('published_at');
DatePicker::make('date_of_birth');
TimePicker::make('alarm_at');
DatePicker::make('date_of_birth')
    ->minDate(now()->subYears(150))
    ->maxDate(now());

DateTimePicker::make('date')
    ->label('Appointment date')
    ->minDate(now())
    ->maxDate(Carbon::now()->addDays(30))
    ->disabledDates(['2022-10-02', '2022-10-05', '2022-10-15']);


use Filament\Forms\Components\FileUpload;
 
FileUpload::make('attachment');


FileUpload::make('attachment')
    ->disk('s3')
    ->directory('form-attachments')
    ->visibility('private');
     FileUpload::make('attachment')->preserveFilenames();
  FileUpload::make('attachment')
    ->imagePreviewHeight('250')
    ->loadingIndicatorPosition('left')
    ->panelAspectRatio('2:1')
    ->panelLayout('integrated')
    ->removeUploadedFileButtonPosition('right')
    ->uploadButtonPosition('left')
    ->uploadProgressIndicatorPosition('left');


    use Filament\Forms\Components\MarkdownEditor;
 
MarkdownEditor::make('content');

use Filament\Forms\Components\Repeater;
 
Repeater::make('members')
    ->schema([
        TextInput::make('name')->required(),
        Select::make('role')
            ->options([
                'member' => 'Member',
                'administrator' => 'Administrator',
                'owner' => 'Owner',
            ])
            ->required(),
    ])
    ->columns(2);


use Filament\Forms\Components\Builder;

/*
Similar to a repeater, the builder component allows you to output a JSON array of repeated form components. Unlike the repeater, which only defines one form schema to repeat, the builder allows you to define different schema "blocks", which you can repeat in any order. This makes it useful for building more advanced array structures.

*/
 
Builder::make('content')
    ->blocks([
        Builder\Block::make('heading')
            ->schema([
                TextInput::make('content')
                    ->label('Heading')
                    ->required(),
                Select::make('level')
                    ->options([
                        'h1' => 'Heading 1',
                        'h2' => 'Heading 2',
                        'h3' => 'Heading 3',
                        'h4' => 'Heading 4',
                        'h5' => 'Heading 5',
                        'h6' => 'Heading 6',
                    ])
                    ->required(),
            ]),
        Builder\Block::make('paragraph')
            ->schema([
                MarkdownEditor::make('content')
                    ->label('Paragraph')
                    ->required(),
            ]),
        Builder\Block::make('image')
            ->schema([
                FileUpload::make('url')
                    ->label('Image')
                    ->image()
                    ->required(),
                TextInput::make('alt')
                    ->label('Alt text')
                    ->required(),
            ]),
        ]);


?>
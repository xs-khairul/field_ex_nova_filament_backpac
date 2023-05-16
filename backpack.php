<?php
#url: https://backpackforlaravel.com/docs/5.x/crud-fields
#So at minimum, a field definition array usually looks like:

[
    'name'  => 'description',
    'label' => 'Article Description',
    'type'  => 'textarea',
]
/*[
    'prefix'     => '',
    'suffix'     => '',
    'default'    => 'some value', // set a default value
    'hint'       => 'Some hint text', // helpful text, shows up after the input
    'attributes' => [
       'placeholder' => 'Some text when empty',
       'class'       => 'form-control some-class',
       'readonly'    => 'readonly',
       'disabled'    => 'disabled',
     ], // change the HTML attributes of your input
     'wrapper'   => [ 
        'class'      => 'form-group col-md-12'
     ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
]*/
[
    'prefix'     => '',
    'suffix'     => '',
    'default'    => 'some value', // set a default value
    'hint'       => 'Some hint text', // helpful text, shows up after the input
    'attributes' => [
       'placeholder' => 'Some text when empty',
       'class'       => 'form-control some-class',
       'readonly'    => 'readonly',
       'disabled'    => 'disabled',
     ], // change the HTML attributes of your input
     'wrapper'   => [ 
        'class'      => 'form-group col-md-12'
     ], // change the HTML attributes for the field wrapper - mostly for resizing fields 
]

#show the field, but don't store it in the database column above
[
    'name'     => 'name', // JSON variable name
    'label'    => "Tag Name", // human-readable label for the input

    'fake'     => true, // show the field, but don't store it in the database column above
    'store_in' => 'extras' // [optional] the database column name where you want the fake fields to ACTUALLY be stored as a JSON array 
],

[   // Switch
    'name'  => 'switch',
    'type'  => 'switch',
    'label'    => 'I have not read the terms and conditions and I never will',

    // optional
    'color'    => 'primary', // May be any bootstrap color class or an hex color
    'onLabel' => '✓',
    'offLabel' => '✕',
],


[   // Text
    'name'  => 'title',
    'label' => "Title",
    'type'  => 'text',

    // optional
    //'prefix'     => '',
    //'suffix'     => '',
    //'default'    => 'some value', // default value
    //'hint'       => 'Some hint text', // helpful text, show up after input
    //'attributes' => [
       //'placeholder' => 'Some text when empty',
       //'class' => 'form-control some-class',
       //'readonly'  => 'readonly',
       //'disabled'  => 'disabled',
     //], // extra HTML attributes and values your input might need
     //'wrapper'   => [
       //'class' => 'form-group col-md-12'
     //], // extra HTML attributes for the field wrapper - mostly for resizing fields

],

[   // Textarea
    'name'  => 'description',
    'label' => 'Description',
    'type'  => 'textarea'
],

[   // Upload
    'name'      => 'image',
    'label'     => 'Image',
    'type'      => 'upload',
    'upload'    => true,
    'disk'      => 'uploads', // if you store files in the /public folder, please omit this; if you store them in /storage or S3, please specify it;
    // optional:
    'temporary' => 10 // if using a service, such as S3, that requires you to make temporary URLs this will make a URL that is valid for the number of minutes specified
],

/*
If you need your fakes to also be translatable, remember to also place extras in your model's $translatable property and remove it from $casts. */

[
    'name'     => 'meta_title',
    'label'    => "Meta Title", 
    'fake'     => true, 
    'store_in' => 'metas' // [optional]
],
[
    'name'     => 'meta_description',
    'label'    => "Meta Description", 
    'fake'     => true, 
    'store_in' => 'metas' // [optional]
],
[
    'name'     => 'meta_keywords',
    'label'    => "Meta Keywords", 
    'fake'     => true, 
    'store_in' => 'metas' // [optional]
],

#In this example, these 3 fields will show up in the create & update forms, the CRUD will process as usual, but in the database these values won't be stored in the meta_title, meta_description and meta_keywords columns. They will be stored in the metas column as a JSON array:
{"meta_title":"title","meta_description":"desc","meta_keywords":"keywords"};

#In order to use this feature, you just need to specify the tab name for each of your fields. Example:
// select_from_array
$this->crud->addField([
    'name'            => 'select_from_array',
    'label'           => "Select from array",
    'type'            => 'select_from_array',
    'options'         => ['one' => 'One', 'two' => 'Two', 'three' => 'Three'],
    'allows_null'     => false,
    'allows_multiple' => true,
    'tab'             => 'Tab name here',
]);

#Checklist
[   // Checklist
    'label'     => 'Roles',
    'type'      => 'checklist',
    'name'      => 'roles',
    'entity'    => 'roles',
    'attribute' => 'name',
    'model'     => "Backpack\PermissionManager\app\Models\Role",
    'pivot'     => true,
    // 'number_of_columns' => 3,
],

# two interconnected entities
[   // two interconnected entities
    'label'             => 'User Role Permissions',
    'field_unique_name' => 'user_role_permission',
    'type'              => 'checklist_dependency',
    'name'              => ['roles', 'permissions'], // the methods that define the relationship in your Models
    'subfields'         => [
        'primary' => [
            'label'            => 'Roles',
            'name'             => 'roles', // the method that defines the relationship in your Model
            'entity'           => 'roles', // the method that defines the relationship in your Model
            'entity_secondary' => 'permissions', // the method that defines the relationship in your Model
            'attribute'        => 'name', // foreign key attribute that is shown to user
            'model'            => "Backpack\PermissionManager\app\Models\Role", // foreign key model
            'pivot'            => true, // on create&update, do you need to add/delete pivot table entries?]
            'number_columns'   => 3, //can be 1,2,3,4,6
        ],
        'secondary' => [
            'label'          => 'Permission',
            'name'           => 'permissions', // the method that defines the relationship in your Model
            'entity'         => 'permissions', // the method that defines the relationship in your Model
            'entity_primary' => 'roles', // the method that defines the relationship in your Model
            'attribute'      => 'name', // foreign key attribute that is shown to user
            'model'          => "Backpack\PermissionManager\app\Models\Permission", // foreign key model
            'pivot'          => true, // on create&update, do you need to add/delete pivot table entries?]
            'number_columns' => 3, //can be 1,2,3,4,6
        ],
    ],
],


[   // Date
    'name'  => 'birthday',
    'label' => 'Birthday',
    'type'  => 'date'
],


[   // Email
    'name'  => 'email',
    'label' => 'Email Address',
    'type'  => 'email'
],
[   // Hidden
    'name'  => 'status',
    'type'  => 'hidden',
    'value' => 'active',
],
#Since not all browsers support this input type, if you are using Backpack PRO you can customize the date_picker field to have a similar behavior:
[   
    'name'  => 'month',
    'type'  => 'date_picker',
    'date_picker_options' => [
        'format'   => 'yyyy-mm',
        'minViewMode' => 'months'
    ],
]


[   // Number
    'name' => 'number',
    'label' => 'Number',
    'type' => 'number',

    // optionals
    // 'attributes' => ["step" => "any"], // allow decimals
    // 'prefix'     => "$",
    // 'suffix'     => ".00",
],

[   // radio
    'name'        => 'status', // the name of the db column
    'label'       => 'Status', // the input label
    'type'        => 'radio',
    'options'     => [
        // the key will be stored in the db, the value will be shown as label; 
        0 => "Draft",
        1 => "Published"
    ],
    // optional
    //'inline'      => false, // show the radios all on the same line?
],



[   // Range
    'name'  => 'range',
    'label' => 'Range',
    'type'  => 'range',
    //optional
    'attributes' => [
        'min' => 0,
        'max' => 10,
    ],
],

/*
Show a Select with the names of the connected entity and let the user select one of them. Your relationships should already be defined on your models as hasOne() or belongsTo()
*/

[  // Select
   'label'     => "Category",
   'type'      => 'select',
   'name'      => 'category_id', // the db column for the foreign key

   // optional
   // 'entity' should point to the method that defines the relationship in your Model
   // defining entity will make Backpack guess 'model' and 'attribute'
   'entity'    => 'category',

   // optional - manually specify the related model and attribute
   'model'     => "App\Models\Category", // related model
   'attribute' => 'name', // foreign key attribute that is shown to user

   // optional - force the related options to be a custom query, instead of all();
   'options'   => (function ($query) {
        return $query->orderBy('name', 'ASC')->where('depth', 1)->get();
    }), //  you can use this to filter the results show in the select
],


/*This button allows the admin to open elFinder and select a file from there. Run composer require backpack/filemanager && php artisan backpack:filemanager:install to install FileManager, then you can use the field:*/

[   // Upload
    'name'      => 'image',
    'label'     => 'Image',
    'type'      => 'upload',
    'upload'    => true,
    'disk'      => 'uploads', // if you store files in the /public folder, please omit this; if you store them in /storage or S3, please specify it;
    // optional:
    'temporary' => 10 // if using a service, such as S3, that requires you to make temporary URLs this will make a URL that is valid for the number of minutes specified
],




[   // CKEditor
    'name'          => 'description',
    'label'         => 'Description',
    'type'          => 'ckeditor',

    // optional:
    'extra_plugins' => ['oembed', 'widget'],
    'options'       => [
        'autoGrow_minHeight'   => 200,
        'autoGrow_bottomSpace' => 50,
        'removePlugins'        => 'resize,maximize',
    ]
],


#Step 1. Add inline_create to your field definition in the current CrudController:

// for 1-n relationships (ex: category)
[
    'type'          => "relationship",
    'name'          => 'category',
    'ajax'          => true,
    'inline_create' => true, // <--- THIS
],
// for n-n relationships (ex: tags)
[
    'type'          => "relationship",
    'name'          => 'tags', // the method on your model that defines the relationship
    'ajax'          => true,
    'inline_create' => [ 'entity' => 'tag' ]  // <--- OR THIS
],
// in this second example, the relation is called `tags` (plural),
// but we need to define the entity as "tag" (singural)





/*To achieve the above, you just need to add a relationship field for your hasMany or morphMany relationship and define the subfields you want for that secondary Model:*/


[
    'name'          => 'items',
    'type'          => "relationship",
    'subfields'   => [
        [
            'name' => 'order',
            'type' => 'number',
            'wrapper' => [
                'class' => 'form-group col-md-1',
            ],
        ],
        [
            'name' => 'description',
            'type' => 'text',
            'wrapper' => [
                'class' => 'form-group col-md-6',
            ],
        ],
        [
            'name' => 'unit',
            'label' => 'U.M.',
            'type' => 'text',
            'wrapper' => [
                'class' => 'form-group col-md-1',
            ],
        ],
        [
            'name' => 'quantity',
            'type' => 'number',
            'attributes' => ["step" => "any"],
            'wrapper' => [
                'class' => 'form-group col-md-2',
            ],
        ],
        [
            'name' => 'unit_price',
            'type' => 'number',
            'attributes' => ["step" => "any"],
            'wrapper' => [
                'class' => 'form-group col-md-2',
            ],
        ],
    ],
]




?>
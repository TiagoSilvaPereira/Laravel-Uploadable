# Laravel-Uploadable

Laravel Uploadable trait to automatically upload images and files with minimum configuration. 

## Introduction

This package can help you to easily make uploads, using only one field in the database, and some simple attributes in your model class. With 
the default configuration, the package makes thumb, medium and normal image uploads. It can be used for other files upload too, like PDF, etc.

## Installation

```
composer require kingofcode/laravel-uploadable
```

This package includes [Intervention Image](http://image.intervention.io/) to resize and manage the images.

## About Upload

This package uses the [Laravel File Storage](https://laravel.com/docs/5.5/filesystem) to keep the file management. The files will 
be stored inside the default disk. To access the images or files, you need to create a symbolic link inside your project:

```
php artisan storage:link
```

And then, configure your default filesystem, inside config/filesystems.php to the public disk:

```
'default' => env('FILESYSTEM_DRIVER', 'public'),
```

## Usage

To use this package, import the Uploadable trait in your model:

```php
use KingOfCode\Upload\Uploadable;
```

And then, configure your uploadable fields for images and files inside your model.

```php
class Product extends Model
{
    use Uploadable;

    protected $fillable = [
        'name',
        'type',
        // Avoid adding file fields in the fillable array, it can break the correct upload
    ];
    
    // Array of uploadable images. These fields need to be existent in your database table
    protected $uploadableImages = [
        'image',
        'perfil_image',
        'test_image'
    ];
    
    // Array of uploadable files. These fields need to be existent in your database table
    protected $uploadableFiles = [
        'pdf'
    ];

}
```

That's all! After this configuration, you can send file data from the client side with the same name of each file field of the model. The package will make the magic!

## Change Image Upload Size

The default sizes (width) for images are:

* thumb - 100px
* medium - 300px
* normal - Image width

You can modify these values directly in the $uploadableImages array. The accepted values are: **image_width** or a number specifying the quantity of pixels.

```php
protected $uploadableImages = [
  'image' => ['thumb' => 150, 'medium' => 500, 'normal' => 700],
  'perfil_image' => ['thumb' => 120, 'medium' => 'image_width', normal => 2000],
  'test_image'
];
```

## Change Image Upload Types

By default, this package saves **thumb**, **medium** and **normal** images. To disable some upload type, add this array to your model:

```php
protected $imageResizeTypes = [
  'medium' => false,
  // ... You can disable medium and normal images upload too
];
```

## Setting the upload folder name

The upload will be make inside a specific folder with the name of the model, but in the plural mode. Eg: for the **Product** model, the images will be uploaded to the 'images/products' directory, and the other files, inside 'files/products'. If you want to modify this directory, add this code to your model:

```php
public $uploadFolderName = 'products'; // Name of your folder
```

## Getting the File Path inside Views, etc

To get a image file path, you can call **getImagePath($imageField, $type)** from your object. Eg:

```php

$product = Product::find(1);

$normal_image = $product->getImagePath('image');
$thumb_image = $product->getImagePath('image', 'thumb');
$medium_perfil_image = $product->getImagePath('perfil_image', 'medium');

```

And to get a simple file path, call **getFilePath($fileField)**:

```php

$product = Product::find(1);

$pdf = $product->getFilePath('pdf');

```

## Inspiration

The basic structure of this package is inspired in the [Laravel Auto Upload](https://github.com/dees040/laravel-auto-upload)

## Contributing

Feel free to comment, open issues and send PR's. Enjoy it!!

## License

MIT

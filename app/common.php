<?php

use App\Models\Product;

if (! function_exists('imagePath')) {
    function imagePath($path)
    {

        return url('/').$path;
    }
}

if (! function_exists('placeholderVisible')) {
    function placeholderVisible()
    {
        $flag = false;

        return ! $flag;
        if (auth()->user()->user_type == 'superadmin') {
            return ! $flag;
        } elseif (auth()->user()->user_type == 'admin' && auth()->user()->is_placeholder_visible == true) {
            return ! $flag;
        } elseif (auth()->user()->user_type == 'employee' && auth()->user()->is_placeholder_visible == true) {
            return ! $flag;
        }

    }
}

if (! function_exists('langUrl')) {
    function langUrl($name)
    {
        return route($name, app()->getLocale());
    }
}

if (! function_exists('paymentStatus')) {
    function paymentStatus($status = null)
    {
        $options = '';

        $payments = ['Paid', 'Pending', 'Partial'];

        foreach ($payments as $payment) {
            $select = '';
            if ($payment == $status) {
                $select = 'selected';
            }
            $options .= '<option value="'.$payment.'" '.$select.' >'.$payment.'</option>';
        }

        return $options;
    }
}

if (! function_exists('paymentMethods')) {
    function paymentMethods($method = null)
    {
        $options = '';

        $payment_methods = ['Cash', 'Bank Transfer', 'Mobile Account', 'Other'];
        foreach ($payment_methods as $payment_method) {
            $select = '';
            if ($payment_method == $method) {
                $select = 'selected';
            }
            $options .= '<option value="'.$payment_method.'" '.$select.'>'.$payment_method.'</option>';
        }

        return $options;
    }
}

if (! function_exists('changeDateFormat')) {
    function changeDateFormat($date, $format)
    {
        return date($format, strtotime($date));
    }
}

/**
 * Shortcut for accessing the config theme.
 *
 * @param  string  $file
 * @return string
 */
if (! function_exists('theme')) {
    function theme($file = null)
    {

        // Laravel perfers dot notation for view file names, especially in test
        $dot_file = str_replace('/', '.', $file);
        $dot_file = preg_replace('/^\./', '', $dot_file);

        // To check the file's existance, we need '/' in files however
        $file_name = str_replace('.', '/', $file);
        $file_name = preg_replace('/^\//', '', $file_name);

        $theme_file = resource_path(
            'views/'.
                "/{$file_name}.blade.php"
        );

        return file_exists($theme_file) ? "$dot_file" : "$dot_file";
    }
}

function image($dir, $image, $style)
{

    $dir = $dir;
    $image = $image ?? 'images/no-image.png';
    $image_path = asset($dir.'/'.$image);

    return '<img src="'.$image_path.'" '.$style[0].' '.$style[1].'
                                    alt="..." >';
}

function productCode()
{

    if (is_null(Product::withoutGlobalScope('user_role_filter')->latest()->first())) {
        $total = 1;
    } else {
        $total = Product::withoutGlobalScope('user_role_filter')->latest()->first()->id + 1;
    }
    // dd($total);
    $sixDigitCode = str_pad($total, 6, '0', STR_PAD_LEFT);

    return $sixDigitCode;
}

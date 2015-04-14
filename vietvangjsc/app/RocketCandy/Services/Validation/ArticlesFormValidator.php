<?php
 
namespace App\RocketCandy\Services\Validation;
 
class ArticlesFormValidator extends Validator {
 
    /**
     * @var array Validation rules for the test form, they can contain in-built Laravel rules or our custom rules
     */
    public $rules = array(
        'category_id' => array( 'required', 'numeric', 'min:1' ),
        'menu_id' => array( 'required', 'numeric', 'min:1'  ),
        //'image' => array( 'required'),
        'title' => array( 'required', 'max:255' ),
        'desc' => array( 'required'),
        'fulltext' => array( 'required' ),
        'image_en' => array( 'image' ),
        'title_en' => array( 'required_with:desc_en,fulltext_en', 'max:255' ),
        'desc_en' => array( 'required_with:title_en,fulltext_en' ),
        'fulltext_en' => array( 'required_with:title_en,desc_en'),
        'image_ja' => array( 'image' ),
        'title_ja' => array( 'required_with:desc_ja,fulltext_ja', 'max:255' ),
        'desc_ja' => array( 'required_with:title_ja,fulltext_ja' ),
        'fulltext_ja' => array( 'required_with:title_ja,desc_ja' ),
        'keywords' => array( 'required', 'max:500' ),
        'description' => array( 'max:500' ),
        'author' => array( 'max:255' ),
        'google_publisher' => array( 'max:255' ),
        'google_author' => array( 'max:255' ),
        'facebook_id' => array( 'max:255' ),
        'og_title' => array( 'max:255' ),
        'og_description' => array( 'max:255' ),
    );
 
}   //end of class
 
 
//EOF
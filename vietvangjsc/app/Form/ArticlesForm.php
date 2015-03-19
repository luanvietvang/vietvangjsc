<?php
 
namespace RocketCandy\Services\Validation;
 
class ArticlesForm extends Validator {
 
    /**
     * @var array Validation rules for the test form, they can contain in-built Laravel rules or our custom rules
     */
    public $rules = array(
        'category_id' => array( 'required', 'numeric', 'min:1' ),
        'menu_id' => array( 'required', 'numeric', 'min:1'  ),
        'image' => array( 'required','image'),
        'title' => array( 'required', 'size:255' ),
        'desc' => array( 'required'),
        'fulltext' => array( 'required' ),
        'image_en' => array( 'image' ),
        'title_en' => array( 'required_with:desc_en,fulltext_en', 'size:255' ),
        'desc_en' => array( 'required_with:title_en,fulltext_en' ),
        'fulltext_en' => array( 'required_with:title_en,desc_en'),
        'image_ja' => array( 'image' ),
        'title_ja' => array( 'required_with:desc_ja,fulltext_ja', 'size:255' ),
        'desc_ja' => array( 'required_with:title_ja,fulltext_ja' ),
        'fulltext_ja' => array( 'required_with:title_ja,desc_ja' ),
        'keywords' => array( 'required', 'size:500' ),
        'description' => array( 'size:500' ),
        'author' => array( 'size:255' ),
        'google_publisher' => array( 'size:255' ),
        'google_author' => array( 'size:255' ),
        'facebook_id' => array( 'size:255' ),
        'og_title' => array( 'size:255' ),
        'og_description' => array( 'size:255' ),
    );
 
}   //end of class
 
 
//EOF
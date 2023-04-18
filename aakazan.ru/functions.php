<?php

add_theme_support('post-thumbnails');

// show_admin_bar(false);

// Удаление версии WP из шапки сайта
remove_action('wp_head','wp_generator');

// Отменяем srcset
add_filter('wp_calculate_image_srcset_meta', '__return_null' );
add_filter('wp_calculate_image_sizes', '__return_false', 99 );
remove_filter('the_content', 'wp_make_content_images_responsive' );

// Отключаем Gutenberg
add_filter('use_block_editor_for_post_type', '__return_false', 100);
add_action('admin_init', function() {
remove_action('admin_notices', ['WP_Privacy_Policy_Content', 'notice']);
add_action('edit_form_after_title', ['WP_Privacy_Policy_Content', 'notice']); 
});
function gut_style_disable() { wp_dequeue_style('wp-block-library'); }
add_action('wp_enqueue_scripts', 'gut_style_disable', 100);


// Убрать версию WP у файлов .css и .js
add_filter( 'style_loader_src', 'remove_cssjs_ver', 10, 2 );
add_filter( 'script_loader_src', 'remove_cssjs_ver', 10, 2 );
function remove_cssjs_ver( $src ) {
if( strpos($src,'?ver='))
$src = remove_query_arg( 'ver', $src );
return $src;
}

// Удаляем стили .recentcomments, они появляются при выводе виджета "последние комментарии":

function ny_remove_recent_comments_style() {
  global $wp_widget_factory;
  remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
}
add_action( 'widgets_init', 'ny_remove_recent_comments_style' );


function add_styles_and_scripts(){

  wp_enqueue_style( 'style', get_stylesheet_uri() );
  wp_enqueue_style( 'main', get_template_directory_uri() . '/assets/css/main.css');

  wp_deregister_script( 'jquery-core' );
	wp_register_script( 'jquery-core', 'https://code.jquery.com/jquery-3.2.1.min.js');
	wp_enqueue_script( 'jquery' );
}

add_action('wp_enqueue_scripts','add_styles_and_scripts');

use Carbon_Fields\Container;
use Carbon_Fields\Field;

add_action( 'carbon_register_fields', 'crb_attach_theme_options' ); 
function crb_attach_theme_options() {
	Container::make( 'theme_options','Собрания' )
		->set_icon('dashicons-admin-home')
		/* Понедельник */
			->add_tab('Понедельник',[
				Field::make( 'complex', 'add', 'Собрания' )
				->set_layout('tabbed-horizontal')
				->add_fields('group','Группа',[
					Field::make('text','point','Адрес')
					->set_default_value('Ул.')
						->set_required(true)
							->set_width(30),
					Field::make('text','name_group','Название группы')
					->set_default_value('Исток')
						->set_required(true)
							->set_width(30),
							// ->add_class('')
				Field::make('text','time','Время')
					->set_default_value('18:00')
						->set_required(true)
							->set_width(30),
				Field::make('text','name','Имя кординатора')
					->set_default_value('Имя')
						->set_required(false)
							->set_width(50),
				Field::make('text','phone','Тел. кординатора')
					->set_default_value('+7')
						->set_required(false)
							->set_width(50),
				Field::make('select', 'select_open_group','Тип группы')
					->set_options([
						'open' => 'Все собрания открытые',
						'close' => 'Закрытое собрание',
						'open1' => 'Открытые собрания: первый понедельник месяца',
						'open2' => 'Открытые собрания: первый вторник месяца',
						'open3' => 'Открытые собрания: второй вторник месяца',
						'open4' => 'Открытые собрания: первая среда месяца',
						'open7' => 'Открытые собрания: каждый четверг',
						'open5' => 'Открытые собрания: первая пятница месяца',
						'open9' => 'Открытые собрания: вторая пятница месяца',
						'open8' => 'Окрытые собрания: последняя пятница месяца',
						'open6' => 'Открытые собрания: первая суббота месяца',
						'open11' => 'Открытые собрания: третья суббота месяца',
						'open10' => 'Открытое собрание последняя суббота месяца',
					])
					->set_width(30),
					Field::make('textarea','desc','Описание')
						->set_default_value('Пройти вдоль')
							->set_required(false)
							->set_width(30),
						Field::make('text','map','Ссылка на карту')
						->set_required(false)
						->help_text('без https://')
						->set_width(30),
				])
				        ->set_header_template('
        <# if (name_group) { #>
          {{ name_group }} 
        <# } #>
        ')
				])

				/* Вторник */
			->add_tab('Вторник',[
				Field::make( 'complex', 'add2', 'Собрания' )
				->set_layout('tabbed-horizontal')
				->add_fields('group','Группа',[
					Field::make('text','point2','Адрес')
					->set_default_value('Ул.')
						->set_required(true)
							->set_width(30),
					Field::make('text','name_group2','Название группы')
					->set_default_value('Исток')
						->set_required(true)
							->set_width(30),
							// ->add_class('')
				Field::make('text','time2','Время')
					->set_default_value('18:00')
						->set_required(true)
							->set_width(30),
				Field::make('text','name2','Имя кординатора')
					->set_default_value('Имя')
						->set_required(false)
							->set_width(50),
				Field::make('text','phone2','Тел. кординатора')
					->set_default_value('+7')
						->set_required(false)
							->set_width(50),
				Field::make('select', 'select_open_group2','Тип группы')
					->set_options([
						'open' => 'Все собрания открытые',
						'close' => 'Закрытое собрание',
						'open1' => 'Открытые собрания: первый понедельник месяца',
						'open2' => 'Открытые собрания: первый вторник месяца',
						'open3' => 'Открытые собрания: второй вторник месяца',
						'open4' => 'Открытые собрания: первая среда месяца',
						'open7' => 'Открытые собрания: каждый четверг',
						'open5' => 'Открытые собрания: первая пятница месяца',
						'open9' => 'Открытые собрания: вторая пятница месяца',
						'open8' => 'Окрытые собрания: последняя пятница месяца',
						'open6' => 'Открытые собрания: первая суббота месяца',
						'open11' => 'Открытые собрания: третья суббота месяца',
						'open10' => 'Открытое собрание последняя суббота месяца',
					])
					->set_width(30),
					Field::make('textarea','desc2','Описание')
						->set_default_value('Пройти вдоль')
							->set_required(false)
							->set_width(30),
						Field::make('text','map2','Ссылка на карту')
						->set_required(false)
						->help_text('без https://')
						->set_width(30),
				])
								        ->set_header_template('
        <# if (name_group2) { #>
          {{ name_group2 }} 
        <# } #>
        ')
				])

						/* Среда */
			->add_tab('Среда',[
				Field::make( 'complex', 'add3', 'Собрания' )
				->set_layout('tabbed-horizontal')
				->add_fields('group','Группа',[
					Field::make('text','point3','Адрес')
					->set_default_value('Ул.')
						->set_required(true)
							->set_width(30),
					Field::make('text','name_group3','Название группы')
					->set_default_value('Исток')
						->set_required(true)
							->set_width(30),
							// ->add_class('')
				Field::make('text','time3','Время')
					->set_default_value('18:00')
						->set_required(true)
							->set_width(30),
				Field::make('text','name3','Имя кординатора')
					->set_default_value('Имя')
						->set_required(false)
							->set_width(50),
				Field::make('text','phone3','Тел. кординатора')
					->set_default_value('+7')
						->set_required(false)
							->set_width(50),
				Field::make('select', 'select_open_group3','Тип группы')
					->set_options([
						'open' => 'Все собрания открытые',
						'close' => 'Закрытое собрание',
						'open1' => 'Открытые собрания: первый понедельник месяца',
						'open2' => 'Открытые собрания: первый вторник месяца',
						'open3' => 'Открытые собрания: второй вторник месяца',
						'open4' => 'Открытые собрания: первая среда месяца',
						'open7' => 'Открытые собрания: каждый четверг',
						'open5' => 'Открытые собрания: первая пятница месяца',
						'open9' => 'Открытые собрания: вторая пятница месяца',
						'open8' => 'Окрытые собрания: последняя пятница месяца',
						'open6' => 'Открытые собрания: первая суббота месяца',
						'open11' => 'Открытые собрания: третья суббота месяца',
						'open10' => 'Открытое собрание последняя суббота месяца',
					])
					->set_width(30),
					Field::make('textarea','desc3','Описание')
						->set_default_value('Пройти вдоль')
							->set_required(false)
							->set_width(30),
						Field::make('text','map3','Ссылка на карту')
						->set_required(false)
						->help_text('без https://')
						->set_width(30),
				])
								        ->set_header_template('
        <# if (name_group3) { #>
          {{ name_group3 }} 
        <# } #>
        ')
				])

							/* Четверг */
			->add_tab('Четверг',[
				Field::make( 'complex', 'add4', 'Собрания' )
				->set_layout('tabbed-horizontal')
				->add_fields('group','Группа',[
					Field::make('text','point4','Адрес')
					->set_default_value('Ул.')
						->set_required(true)
							->set_width(30),
					Field::make('text','name_group4','Название группы')
					->set_default_value('Исток')
						->set_required(true)
							->set_width(30),
							// ->add_class('')
				Field::make('text','time4','Время')
					->set_default_value('18:00')
						->set_required(true)
							->set_width(30),
				Field::make('text','name4','Имя кординатора')
					->set_default_value('Имя')
						->set_required(false)
							->set_width(50),
				Field::make('text','phone4','Тел. кординатора')
					->set_default_value('+7')
						->set_required(false)
							->set_width(50),
				Field::make('select', 'select_open_group4','Тип группы')
					->set_options([
						'open' => 'Все собрания открытые',
						'close' => 'Закрытое собрание',
						'open1' => 'Открытые собрания: первый понедельник месяца',
						'open2' => 'Открытые собрания: первый вторник месяца',
						'open3' => 'Открытые собрания: второй вторник месяца',
						'open4' => 'Открытые собрания: первая среда месяца',
						'open7' => 'Открытые собрания: каждый четверг',
						'open5' => 'Открытые собрания: первая пятница месяца',
						'open9' => 'Открытые собрания: вторая пятница месяца',
						'open8' => 'Окрытые собрания: последняя пятница месяца',
						'open6' => 'Открытые собрания: первая суббота месяца',
						'open11' => 'Открытые собрания: третья суббота месяца',
						'open10' => 'Открытое собрание последняя суббота месяца',
					])
					->set_width(30),
					Field::make('textarea','desc4','Описание')
						->set_default_value('Пройти вдоль')
							->set_required(false)
							->set_width(30),
						Field::make('text','map4','Ссылка на карту')
						->set_required(false)
						->help_text('без https://')
						->set_width(30),
				])
								        ->set_header_template('
        <# if (name_group4) { #>
          {{ name_group4 }} 
        <# } #>
        ')
				])

											/* Пятница */
			->add_tab('Пятница',[
				Field::make( 'complex', 'add5', 'Собрания' )
				->set_layout('tabbed-horizontal')
				->add_fields('group','Группа',[
					Field::make('text','point5','Адрес')
					->set_default_value('Ул.')
						->set_required(true)
							->set_width(30),
					Field::make('text','name_group5','Название группы')
					->set_default_value('Исток')
						->set_required(true)
							->set_width(30),
							// ->add_class('')
				Field::make('text','time5','Время')
					->set_default_value('18:00')
						->set_required(true)
							->set_width(30),
				Field::make('text','name5','Имя кординатора')
					->set_default_value('Имя')
						->set_required(false)
							->set_width(50),
				Field::make('text','phone5','Тел. кординатора')
					->set_default_value('+7')
						->set_required(false)
							->set_width(50),
				Field::make('select', 'select_open_group5','Тип группы')
					->set_options([
						'open' => 'Все собрания открытые',
						'close' => 'Закрытое собрание',
						'open1' => 'Открытые собрания: первый понедельник месяца',
						'open2' => 'Открытые собрания: первый вторник месяца',
						'open3' => 'Открытые собрания: второй вторник месяца',
						'open4' => 'Открытые собрания: первая среда месяца',
						'open7' => 'Открытые собрания: каждый четверг',
						'open5' => 'Открытые собрания: первая пятница месяца',
						'open9' => 'Открытые собрания: вторая пятница месяца',
						'open8' => 'Окрытые собрания: последняя пятница месяца',
						'open6' => 'Открытые собрания: первая суббота месяца',
						'open11' => 'Открытые собрания: третья суббота месяца',
						'open10' => 'Открытое собрание последняя суббота месяца',
					])
					->set_width(30),
					Field::make('textarea','desc5','Описание')
						->set_default_value('Пройти вдоль')
							->set_required(false)
							->set_width(30),
						Field::make('text','map5','Ссылка на карту')
						->set_required(false)
						->help_text('без https://')
						->set_width(30),
				])
								        ->set_header_template('
        <# if (name_group5) { #>
          {{ name_group5 }} 
        <# } #>
        ')
				])

											/* Суббота */
			->add_tab('Суббота',[
				Field::make( 'complex', 'add6', 'Собрания' )
				->set_layout('tabbed-horizontal')
				->add_fields('group','Группа',[
					Field::make('text','point6','Адрес')
					->set_default_value('Ул.')
						->set_required(true)
							->set_width(30),
					Field::make('text','name_group6','Название группы')
					->set_default_value('Исток')
						->set_required(true)
							->set_width(30),
							// ->add_class('')
				Field::make('text','time6','Время')
					->set_default_value('18:00')
						->set_required(true)
							->set_width(30),
				Field::make('text','name6','Имя кординатора')
					->set_default_value('Имя')
						->set_required(false)
							->set_width(50),
				Field::make('text','phone6','Тел. кординатора')
					->set_default_value('+7')
						->set_required(false)
							->set_width(50),
				Field::make('select', 'select_open_group6','Тип группы')
					->set_options([
						'open' => 'Все собрания открытые',
						'close' => 'Закрытое собрание',
						'open1' => 'Открытые собрания: первый понедельник месяца',
						'open2' => 'Открытые собрания: первый вторник месяца',
						'open3' => 'Открытые собрания: второй вторник месяца',
						'open4' => 'Открытые собрания: первая среда месяца',
						'open7' => 'Открытые собрания: каждый четверг',
						'open5' => 'Открытые собрания: первая пятница месяца',
						'open9' => 'Открытые собрания: вторая пятница месяца',
						'open8' => 'Окрытые собрания: последняя пятница месяца',
						'open6' => 'Открытые собрания: первая суббота месяца',
						'open11' => 'Открытые собрания: третья суббота месяца',
						'open10' => 'Открытое собрание последняя суббота месяца',
					])
					->set_width(30),
					Field::make('textarea','desc6','Описание')
						->set_default_value('Пройти вдоль')
							->set_required(false)
							->set_width(30),
						Field::make('text','map6','Ссылка на карту')
						->set_required(false)
						->help_text('без https://')
						->set_width(30),
				])
								        ->set_header_template('
        <# if (name_group6) { #>
          {{ name_group6 }} 
        <# } #>
        ')
				])

											/* Воскресенье */
			->add_tab('Воскресенье',[
				Field::make( 'complex', 'add7', 'Собрания' )
				->set_layout('tabbed-horizontal')
				->add_fields('group','Группа',[
					Field::make('text','point7','Адрес')
					->set_default_value('Ул.')
						->set_required(true)
							->set_width(30),
					Field::make('text','name_group7','Название группы')
					->set_default_value('Исток')
						->set_required(true)
							->set_width(30),
							// ->add_class('')
				Field::make('text','time7','Время')
					->set_default_value('18:00')
						->set_required(true)
							->set_width(30),
				Field::make('text','name7','Имя кординатора')
					->set_default_value('Имя')
						->set_required(false)
							->set_width(50),
				Field::make('text','phone7','Тел. кординатора')
					->set_default_value('+7')
						->set_required(false)
							->set_width(50),
				Field::make('select', 'select_open_group7','Тип группы')
					->set_options([
						'open' => 'Все собрания открытые',
						'close' => 'Закрытое собрание',
						'open1' => 'Открытые собрания: первый понедельник месяца',
						'open2' => 'Открытые собрания: первый вторник месяца',
						'open3' => 'Открытые собрания: второй вторник месяца',
						'open4' => 'Открытые собрания: первая среда месяца',
						'open7' => 'Открытые собрания: каждый четверг',
						'open5' => 'Открытые собрания: первая пятница месяца',
						'open9' => 'Открытые собрания: вторая пятница месяца',
						'open8' => 'Окрытые собрания: последняя пятница месяца',
						'open6' => 'Открытые собрания: первая суббота месяца',
						'open11' => 'Открытые собрания: третья суббота месяца',
						'open10' => 'Открытое собрание последняя суббота месяца',
					])
					->set_width(30),
					Field::make('textarea','desc7','Описание')
						->set_default_value('Пройти вдоль')
							->set_required(false)
							->set_width(30),
						Field::make('text','map7','Ссылка на карту')
						->set_required(false)
						->help_text('без https://')
						->set_width(30),
				])
								        ->set_header_template('
        <# if (name_group7) { #>
          {{ name_group7 }} 
        <# } #>
        ')
					]);
					
					
/* СМИ  */

  Container::make( 'theme_options','АА СМИ' )
  ->set_icon('dashicons-align-center')
    ->add_fields([
      Field::make( 'complex', 'smi_file_add', 'Новость')
      ->set_layout('tabbed-horizontal')
          ->add_fields([
            Field::make('text','smi_text','Заголовок')
            ->set_width(30),
            Field::make('image','smi_image','Постер к видео')
            ->set_width(30)
            ->set_value_type('url'),
            Field::make('file','smi_file','Видео')
            ->set_width(30)
            ->set_value_type('uploadedTo')
            ->set_value_type('url'),
          ])
    ]);
    
     Container::make( 'theme_options','Видеоматериалы' )
    ->set_icon('dashicons-format-video')
      ->add_fields([
          Field::make('text','vd_main_text','Заголовок')
          ->set_width(30),
          Field::make('image','vd_main_image','Постер к видео')
          ->set_width(30)
          ->set_value_type('url'),
          Field::make('file','vd_main_file','Видео')
          ->set_width(30)
          ->set_value_type('uploadedTo')
          ->set_value_type('url'),
        Field::make( 'complex', 'vd', 'Сообщество')
        ->set_layout('tabbed-horizontal')
            ->add_fields([
              Field::make('text','vd_text','Заголовок')
              ->set_width(30),
              Field::make('image','vd_image','Постер к видео')
              ->set_width(30)
              ->set_value_type('url'),
              Field::make('file','vd_file','Видео')
              ->set_width(30)
              ->set_value_type('uploadedTo')
              ->set_value_type('url'),
            ])
      ]);
      
      Container::make( 'theme_options','Л. Истории' )
      ->set_icon('dashicons-format-quote')
        ->add_fields([
          Field::make( 'complex', 'li', 'История')
          ->set_layout('tabbed-horizontal')
              ->add_fields([
                Field::make('text','li_text','Автор')
                ->set_width(50),
                Field::make('rich_text','li_desc','Продолжение истории')
                ->set_width(50)
              ])
        ]);

    Container::make( 'theme_options','Литература' )
      ->set_icon('dashicons-media-document')
        ->add_fields([
          Field::make( 'complex', 'lit', 'Книга')
          ->set_layout('tabbed-horizontal')
              ->add_fields([
                Field::make('text','lit_text','Название')
                ->set_width(30),
                Field::make('image','lit_image','Файл')
                ->set_width(30)
                ->set_value_type('url'),
                Field::make('textarea','lit_desc','Описание')
                ->set_width(30),
              ])
        ]);
        
        Container::make( 'theme_options','Рецензии' )
        ->set_icon('dashicons-format-aside')
          ->add_fields([
            Field::make( 'complex', 'r', 'Фото')
            ->set_layout('tabbed-horizontal')
                ->add_fields([
                  Field::make('image','r_image','Рецензия')
                  ->set_value_type('url'),
                ])
          ]);
				
}



if ( ! function_exists( 'carbon_get_post_meta' ) ) {
	function carbon_get_post_meta( $id, $name, $type = null ) {
		return false;
	}
}

if ( ! function_exists( 'carbon_get_the_post_meta' ) ) {
	function carbon_get_the_post_meta( $name, $type = null ) {
		return false;
	}
}

if ( ! function_exists( 'carbon_get_theme_option' ) ) {
	function carbon_get_theme_option( $name, $type = null ) {
		return false;
	}
}

if ( ! function_exists( 'carbon_get_term_meta' ) ) {
	function carbon_get_term_meta( $id, $name, $type = null ) {
		return false;
	}
}

if ( ! function_exists( 'carbon_get_user_meta' ) ) {
	function carbon_get_user_meta( $id, $name, $type = null ) {
		return false;
	}
}

if ( ! function_exists( 'carbon_get_comment_meta' ) ) {
	function carbon_get_comment_meta( $id, $name, $type = null ) {
		return false;
	}
}

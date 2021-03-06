<?php
define('IN_FORUM', true);
define('FT_SCRIPT', 'faq');
define('FT_ROOT', './');
require(FT_ROOT . 'common.php');

$user->session_start();

// Set vars to prevent naughtiness
$faq = array();
//
// Load the appropriate faq file
//
if (isset($HTTP_GET_VARS['mode'])) {
    switch ($HTTP_GET_VARS['mode']) {
        case 'bbcode':
            $lang_file = 'lang_bbcode';
            $l_title = $lang['BBCode_guide'];
            break;
        default:
            $lang_file = 'lang_faq';
            $l_title = $lang['FAQ'];
            break;
    }
} else {
    $lang_file = 'lang_faq';
    $l_title = $lang['FAQ'];
}
require(FT_ROOT . 'language/lang_' . $ft_cfg['default_lang'] . '/' . $lang_file . '.php');
attach_faq_include($lang_file);


//
// Pull the array data from the lang pack
//
$j = 0;
$counter = 0;
$counter_2 = 0;
$faq_block = array();
$faq_block_titles = array();

for ($i = 0; $i < count($faq); $i++) {
    if ($faq[$i][0] != '--') {
        $faq_block[$j][$counter]['id'] = $counter_2;
        $faq_block[$j][$counter]['question'] = $faq[$i][0];
        $faq_block[$j][$counter]['answer'] = $faq[$i][1];

        $counter++;
        $counter_2++;
    } else {
        $j = ($counter != 0) ? $j + 1 : 0;

        $faq_block_titles[$j] = $faq[$i][1];

        $counter = 0;
    }
}

//
// Lets build a page ...
//
$page_title = $l_title;
require(FT_ROOT . 'includes/page_header.php');

$template->set_filenames(array(
        'body' => 'faq_body.tpl')
);
make_jumpbox('viewforum.php');

$template->assign_vars(array(
        'L_FAQ_TITLE' => $l_title,
        'L_BACK_TO_TOP' => $lang['Back_to_top'])
);

for ($i = 0; $i < count($faq_block); $i++) {
    if (count($faq_block[$i])) {
        $template->assign_block_vars('faq_block', array(
                'BLOCK_TITLE' => $faq_block_titles[$i])
        );
        $template->assign_block_vars('faq_block_link', array(
                'BLOCK_TITLE' => $faq_block_titles[$i])
        );

        for ($j = 0; $j < count($faq_block[$i]); $j++) {
            $template->assign_block_vars('faq_block.faq_row', array(

                    'ROW_CLASS' => !($i % 2) ? 'row1' : 'row2',
                    'FAQ_QUESTION' => $faq_block[$i][$j]['question'],
                    'FAQ_ANSWER' => $faq_block[$i][$j]['answer'],

                    'U_FAQ_ID' => $faq_block[$i][$j]['id'])
            );

            $template->assign_block_vars('faq_block_link.faq_row_link', array(
                    'ROW_CLASS' => !($i % 2) ? 'row1' : 'row2',
                    'FAQ_LINK' => $faq_block[$i][$j]['question'],

                    'U_FAQ_LINK' => '#' . $faq_block[$i][$j]['id'])
            );
        }
    }
}

$template->pparse('body');

require(FT_ROOT . 'includes/page_tail.php');
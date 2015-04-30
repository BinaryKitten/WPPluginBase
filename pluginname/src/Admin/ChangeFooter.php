<?php

namespace BinaryKitten\PluginName\Admin;


class ChangeFooter
{
    protected $proverbs = array(
        'A bully is always a coward.',
        'A handsome shoe often pinches the foot.',
        'A good thing is all the sweeter when won with pain.',
        'A man too careful of danger lives in continual torment.',
        'A miss is as good as a mile.',
        'Adversity flatters no man',
        'Adversity and loss make a man wise',
        'All promises are either broken or kept.',
        'All things come to those that wait.',
        'An eye for an eye and a tooth for a tooth.',
        'An open door may tempt a saint.',
        'As one door closes, another always opens.',
        'As you go through life, make this your goal, watch the doughnut and not the hole.',
        'Brevity is the soul of wit.',
        'Cut your coat according to the cloth.',
        'Discretion is the better part of valour.',
        'Do right and fear no man.',
        'Easy come, easy go.',
        'Experience is the hardest teacher. She gives the test first and the lesson afterwards.',
        'Familiarity breeds contempt.',
        'Fortune favours the brave.'
    );

    public function __construct()
    {
        // add action hooks/filters here
        add_filter('admin_footer_text', array($this, 'changeAdminFooterText'));
    }

    /**
     * @return mixed
     */
    public static function checkCreate()
    {
        return is_admin();
    }

    public function changeAdminFooterText()
    {
        return array_rand($this->proverbs);
    }
}
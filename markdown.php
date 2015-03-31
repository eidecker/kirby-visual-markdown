<?php
/**
 * Visual Markdown Editor Field for Kirby 2
 *
 * @version   1.0.0
 * @author    Jonas Döbertin <hello@jd-powered.net>
 * @copyright Jonas Döbertin <hello@jd-powered.net>
 * @link      https://github.com/JonasDoebertin/kirby-visual-markdown
 * @license   GNU GPL v3.0 <http://opensource.org/licenses/GPL-3.0>
 */

/**
 * Visual Markdown Editor Field
 *
 * @since 1.0.0
 */
class MarkdownField extends InputField {

    /**
     * Define frontend assets
     *
     * @var array
     * @since 1.0.0
     */
    public static $assets = array(
        'js' => array(
            'mirrormark.package.min.js',
            'screenfull.min.js',
            'markdown.js',
        ),
        'css' => array(
            'mirrormark.package.min.css',
            'markdown.css',
        ),
    );

    /**
     * Option: Show/Hide toolbar
     *
     * @since 1.1.0
     *
     * @var string
     */
    protected $toolbar = true;

    /**************************************************************************\
    *                          GENERAL FIELD METHODS                           *
    \**************************************************************************/

    /**
     * Magic setter
     *
     * Set a fields property and apply default value if required.
     *
     * @since 1.1.0
     *
     * @param string $option
     * @param mixed  $value
     */
    public function __set($option, $value)
    {
        /* Set given value */
        $this->$option = $value;

        /* Check if value is valid */
        switch($option)
        {
            case 'toolbar':
                if(in_array($value, array(false, 'hide')))
                {
                    $this->toolbar = false;
                }
                else
                {
                    $this->toolbar = true;
                }
                break;
        }

    }


    /**
     * Convert result to markdown
     *
     * @since 1.0.0
     *
     * @return string
     */
    public function result()
    {
        return str_replace(array("\r\n", "\r"), "\n", parent::result());
    }

    /**************************************************************************\
    *                            PANEL FIELD MARKUP                            *
    \**************************************************************************/

    /**
     * Create input element
     *
     * @since 1.0.0
     *
     * @return \Brick
     */
    public function input()
    {
        // Set up textarea
        $input = parent::input();
        $input->tag('textarea');
        $input->removeAttr('type');
        $input->removeAttr('value');
        $input->html($this->value() ?: false);
        $input->data(array(
            'field'   => 'markdownfield',
            'toolbar' => ($this->toolbar) ? 'true' : 'false',
        ));

        // Set up wrapping element
        $wrapper = new Brick('div', false);
        $wrapper->addClass('markdownfield-wrapper');

        return $wrapper->append($input);
    }

    public function element()
    {
        $element = parent::element();
        $element->addClass('field-with-textarea');
        return $element;
    }

}

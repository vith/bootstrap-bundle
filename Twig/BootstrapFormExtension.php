<?php
/**
 * This file is part of BraincraftedBootstrapBundle.
 * (c) 2012-2013 by Florian Eckerstorfer
 */

namespace Braincrafted\Bundle\BootstrapBundle\Twig;

/**
 * BootstrapFormExtension
 *
 * @package    BraincraftedBootstrapBundle
 * @subpackage Twig
 * @author     Florian Eckerstorfer <florian@eckerstorfer.co>
 * @copyright  2012-2013 Florian Eckerstorfer
 * @license    http://opensource.org/licenses/MIT The MIT License
 * @link       http://bootstrap.braincrafted.com Bootstrap for Symfony2
 */
class BootstrapFormExtension extends \Twig_Extension
{
    /** @var string */
    private $style;

    /** @var string */
    private $colSize = 'lg';

    /** @var integer */
    private $widgetCol = 10;

    /** @var integer */
    private $labelCol = 2;

    /** @var integer */
    private $simpleCol = false;

    /** @var array */
    private $settingsStack = [];

    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('bootstrap_set_style', array($this, 'setStyle')),
            new \Twig_SimpleFunction('bootstrap_get_style', array($this, 'getStyle')),
            new \Twig_SimpleFunction('bootstrap_set_col_size', array($this, 'setColSize')),
            new \Twig_SimpleFunction('bootstrap_get_col_size', array($this, 'getColSize')),
            new \Twig_SimpleFunction('bootstrap_set_widget_col', array($this, 'setWidgetCol')),
            new \Twig_SimpleFunction('bootstrap_get_widget_col', array($this, 'getWidgetCol')),
            new \Twig_SimpleFunction('bootstrap_set_label_col', array($this, 'setLabelCol')),
            new \Twig_SimpleFunction('bootstrap_get_label_col', array($this, 'getLabelCol')),
            new \Twig_SimpleFunction('bootstrap_set_simple_col', array($this, 'setSimpleCol')),
            new \Twig_SimpleFunction('bootstrap_get_simple_col', array($this, 'getSimpleCol')),
            new \Twig_SimpleFunction('bootstrap_backup_form_settings', array($this, 'backupFormSettings')),
            new \Twig_SimpleFunction('bootstrap_restore_form_settings', array($this, 'restoreFormSettings')),
            'checkbox_row'  => new \Twig_Function_Node(
                'Symfony\Bridge\Twig\Node\SearchAndRenderBlockNode',
                array('is_safe' => array('html'))
            ),
            'radio_row'  => new \Twig_Function_Node(
                'Symfony\Bridge\Twig\Node\SearchAndRenderBlockNode',
                array('is_safe' => array('html'))
            ),
            'global_form_errors'  => new \Twig_Function_Node(
                'Symfony\Bridge\Twig\Node\SearchAndRenderBlockNode',
                array('is_safe' => array('html'))
            ),
            'form_control_static'   => new \Twig_Function_Method(
                $this,
                'formControlStaticFunction',
                array('is_safe' => array('html'))
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'braincrafted_bootstrap_form';
    }

    /**
     * Sets the style.
     *
     * @param string $style Name of the style
     */
    public function setStyle($style)
    {
        $this->style = $style;
    }

    /**
     * Returns the style.
     *
     * @return string Name of the style
     */
    public function getStyle()
    {
        return $this->style;
    }

    /**
     * Sets the column size.
     *
     * @param string $colSize Column size (xs, sm, md or lg)
     */
    public function setColSize($colSize)
    {
        $this->colSize = $colSize;
    }

    /**
     * Returns the column size.
     *
     * @return string Column size (xs, sm, md or lg)
     */
    public function getColSize()
    {
        return $this->colSize;
    }

    /**
     * Sets the number of columns of widgets.
     *
     * @param integer $widgetCol Number of columns.
     */
    public function setWidgetCol($widgetCol)
    {
        $this->widgetCol = $widgetCol;
    }

    /**
     * Returns the number of columns of widgets.
     *
     * @return integer Number of columns.
     */
    public function getWidgetCol()
    {
        return $this->widgetCol;
    }

    /**
     * Sets the number of columns of labels.
     *
     * @param integer $labelCol Number of columns.
     */
    public function setLabelCol($labelCol)
    {
        $this->labelCol = $labelCol;
    }

    /**
     * Returns the number of columns of labels.
     *
     * @return integer Number of columns.
     */
    public function getLabelCol()
    {
        return $this->labelCol;
    }

    /**
     * Sets the number of columns of simple widgets.
     *
     * @param integer $simpleCol Number of columns.
     */
    public function setSimpleCol($simpleCol)
    {
        $this->simpleCol = $simpleCol;
    }

    /**
     * Returns the number of columns of simple widgets.
     *
     * @return integer Number of columns.
     */
    public function getSimpleCol()
    {
        return $this->simpleCol;
    }

    /**
     * Backup the form settings to the stack.
     */
    public function backupFormSettings()
    {
        $settings = [
            'style'     => $this->style,
            'colSize'   => $this->colSize,
            'widgetCol' => $this->widgetCol,
            'labelCol'  => $this->labelCol,
            'simpleCol' => $this->simpleCol,
        ];
        array_push($this->settingsStack, $settings);
    }

    /**
     * Restore the form settings from the stack.
     */
    public function restoreFormSettings()
    {
        $settings = array_pop($this->settingsStack);
        $this->style     = $settings['style'];
        $this->colSize   = $settings['colSize'];
        $this->widgetCol = $settings['widgetCol'];
        $this->labelCol  = $settings['labelCol'];
        $this->simpleCol = $settings['simpleCol'];
    }

    public function formControlStaticFunction($label, $value)
    {
        return  sprintf(
            '<div class="form-group"><label class="col-sm-%s control-label">%s</label><div class="col-sm-%s"><p class="form-control-static">%s</p></div></div>',
            $this->getLabelCol(), $label, $this->getWidgetCol(), $value
        );
    }
}

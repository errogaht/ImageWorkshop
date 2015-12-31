<?php
/**
 * Created by PhpStorm.
 * User: Alexey Teterin
 * Email: 7018407@gmail.com
 * Date: 31.12.2015
 * Time: 13:35
 */

namespace PHPImageWorkshop\Gradient;


use PHPImageWorkshop\Color\RGBColor;
use PHPImageWorkshop\Core\ImageWorkshopLayer;

abstract class AbstractGradient
{
    private $start;
    private $end;
    private $step;

    /**
     * construct new gradient
     *
     * @param \PHPImageWorkshop\Color\RGBColor $start
     * @param \PHPImageWorkshop\Color\RGBColor $end
     * @param int                              $step
     *
     */
    public function __construct(RGBColor $start = null, RGBColor $end = null, $step = 0)
    {
        $this->setStartColor($start === null ? RGBColor::fromHex('#000') : $start);
        $this->setEndColor($end === null ? RGBColor::fromHex('#fff') : $end);
        $this->setStep($step);
    }

    public function setStartColor(RGBColor $color)
    {
        $this->start = $color;

        return $this;
    }

    public function setEndColor(RGBColor $color)
    {
        $this->end = $color;

        return $this;
    }

    public function getStep()
    {
        return $this->step;
    }

    public function setStep($step)
    {
        if ($step < 0) {
            throw new \InvalidArgumentException(sprintf(
                'Invalid Gradient Step "%s"', $step
            ));
        }

        $this->step = (int)$step;

        return $this;
    }

    final public function generate($layer)
    {
        return $this->doGenerate($layer);

    }

    abstract protected function doGenerate(ImageWorkshopLayer $layer);

    /**
     * Interpolate color
     *
     * @param integer $amount
     *
     * @return \PHPImageWorkshop\Color\RGBColor
     */
    protected function getColor($amount)
    {
        $s = $this->getStartColor();
        $e = $this->getEndColor();

        $r = ($e->getRed() - $s->getRed() != 0)
            ?
            intval($s->getRed() + ($e->getRed() - $s->getRed()) * $amount)
            :
            $s->getRed();

        $g = ($e->getGreen() - $s->getGreen() != 0)
            ?
            intval($s->getGreen() + ($e->getGreen() - $s->getGreen()) * $amount)
            :
            $s->getGreen();

        $b = ($e->getBlue() - $s->getBlue() != 0)
            ?
            intval($s->getBlue() + ($e->getBlue() - $s->getBlue()) * $amount)
            :
            $s->getBlue();

        $a = ($e->getAlpha() - $s->getAlpha() != 0)
            ?
            intval($s->getAlpha() + ($e->getAlpha() - $s->getAlpha()) * $amount)
            :
            $s->getAlpha();

        return new RGBColor($r, $g, $b, $a);
    }

    public function getStartColor()
    {
        return $this->start;
    }

    public function getEndColor()
    {
        return $this->end;
    }
}
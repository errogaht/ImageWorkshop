<?php
/**
 * Created by PhpStorm.
 * User: Alexey Teterin
 * Email: 7018407@gmail.com
 * Date: 31.12.2015
 * Time: 12:36
 */

namespace PHPImageWorkshop\Gradient;


use PHPImageWorkshop\Core\ImageWorkshopLayer;
use PHPImageWorkshop\Core\ImageWorkshopLib;
use PHPImageWorkshop\ImageWorkshop;

class LinearGradient extends AbstractGradient
{

    /**
     * {@inheritdoc}
     */
    protected function doGenerate(ImageWorkshopLayer $layer)
    {
        $gradientHeight = $layer->getHeight();
        $step = $this->getStep();

        for ($i = 0; $i <= $gradientHeight; $i += $step + 1) {
            $color = $this->getColor($i / $gradientHeight);

            $gradientLine = ImageWorkshopLib::generateImageFromRGB(
                $layer->getWidth(),
                $step + 1,
                $color->getRed(),
                $color->getGreen(),
                $color->getBlue(),
                $color->getAlpha()
            );

            $layer->addLayerOnTop(
                ImageWorkshop::initFromResourceVar($gradientLine),
                0,
                $i
            );
        }
        $layer->mergeAll();

        return $layer;
    }

}
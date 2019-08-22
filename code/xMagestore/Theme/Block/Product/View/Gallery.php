<?php
/**
 * Copyright © Magento, Inc. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Simple product data view
 *
 * @author     Magento Core Team <core@magentocommerce.com>
 */
namespace xMagestore\Theme\Block\Product\View;

use Magento\Framework\DataObject;
/**
 * Product gallery block
 *
 * @api
 * @since 100.0.2
 */
class Gallery extends \Magento\Catalog\Block\Product\View\Gallery
{
    public function aroundGetGalleryImagesJson(
        \Magento\Catalog\Block\Product\View\Gallery $subject,
        $result
    ) {
        $imagesItems = [];
        /** @var DataObject $image */
        foreach ($this->getGalleryImages() as $image) {
            $imageItem = new DataObject([
                'thumb' => $image->getData('url'),
                'img' => $image->getData('url'),
                'full' => $image->getData('url'),
                'caption' => ($image->getLabel() ?: $this->getProduct()->getName()),
                'position' => $image->getData('position'),
                'isMain'   => $this->isMainImage($image),
                'type' => str_replace('external-', '', $image->getMediaType()),
                'videoUrl' => $image->getVideoUrl(),
            ]);
            foreach ($this->getGalleryImagesConfig()->getItems() as $imageConfig) {
                if (in_array($imageConfig->getData('json_object_key'), ['thumb', 'img', 'full'])) {
                    continue;
                }
                $imageItem->setData(
                    $imageConfig->getData('json_object_key'),
                    $image->getData($imageConfig->getData('data_object_key'))
                );
            }
            $imagesItems[] = $imageItem->toArray();
        }
        if (empty($imagesItems)) {
            $imagesItems[] = [
                'thumb' => $this->_imageHelper->getDefaultPlaceholderUrl('thumbnail'),
                'img' => $this->_imageHelper->getDefaultPlaceholderUrl('image'),
                'full' => $this->_imageHelper->getDefaultPlaceholderUrl('image'),
                'caption' => '',
                'position' => '0',
                'isMain' => true,
                'type' => 'image',
                'videoUrl' => null,
            ];
        }
        
        return json_encode($imagesItems);
    }
}

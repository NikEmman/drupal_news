<?php

namespace Drupal\news_front\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;

class NewsFrontController extends ControllerBase
{

    public function content()
    {
        $featured_node_render = [];

        // Query for the most recent article marked as 'featured'
        $storage = \Drupal::entityTypeManager()->getStorage('node');
        $query = $storage->getQuery()
            ->condition('type', 'article')
            ->condition('status', 1) // Published
            ->condition('field_featured', 1) // Featured checkbox
            ->sort('created', 'DESC')
            ->range(0, 1)
            ->accessCheck(TRUE);

        $nids = $query->execute();

        if (!empty($nids)) {
            // Load the node and prepare it for rendering
            $node = $storage->load(reset($nids));
            $view_builder = \Drupal::entityTypeManager()->getViewBuilder('node');

            // Use the 'teaser' view mode, can change to'full'
            $featured_node_render = $view_builder->view($node, 'teaser');
        } else {
            $featured_node_render = ['#markup' => '<p>No featured content available.</p>'];
        }

        return [
            '#theme' => 'news_front_template',
            '#featured_node' => $featured_node_render,
            '#attached' => [
                'library' => [
                    'news_front/news_api_js',
                ],
            ],
        ];
    }
}
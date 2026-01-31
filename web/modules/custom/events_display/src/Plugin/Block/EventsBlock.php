<?php

namespace Drupal\events_display\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use GuzzleHttp\ClientInterface;

/**
 * Provides an 'Events Display' Block.
 *
 * @Block(
 * id = "events_display_block",
 * admin_label = @Translation("Upcoming Events Block"),
 * )
 */
class EventsBlock extends BlockBase implements ContainerFactoryPluginInterface
{

    protected $httpClient;

    public function __construct(array $configuration, $plugin_id, $plugin_definition, ClientInterface $http_client)
    {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->httpClient = $http_client;
    }

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
    {
        return new static(
            $configuration,
            $plugin_id,
            $plugin_definition,
            $container->get('http_client')
        );
    }

    /**
     * 1. Define the Admin Form for Configuration
     */
    public function blockForm($form, FormStateInterface $form_state)
    {
        $form = parent::blockForm($form, $form_state);
        $config = $this->getConfiguration();

        $form['event_count'] = [
            '#type' => 'number',
            '#title' => $this->t('Number of events to display'),
            '#default_value' => $config['event_count'] ?? 5,
            '#min' => 1,
            '#max' => 20,
            '#required' => TRUE,
        ];

        return $form;
    }

    /**
     * 2. Save the Configuration
     */
    public function blockSubmit($form, FormStateInterface $form_state)
    {
        parent::blockSubmit($form, $form_state);
        $this->setConfigurationValue('event_count', $form_state->getValue('event_count'));
    }

    /**
     * 3. Build the Block Output
     */
    public function build()
    {
        $config = $this->getConfiguration();
        $limit = $config['event_count'] ?? 5; // Get the user's choice

        try {
            // Fetch from Laravel API
            $response = $this->httpClient->get('http://127.0.0.1:8000/api/v1/events');
            $data = json_decode($response->getBody()->getContents(), TRUE);
            $events = $data['data'] ?? [];

            // Slice the array based on configuration
            $events = array_slice($events, 0, $limit);

            if (empty($events)) {
                return ['#markup' => $this->t('No upcoming events found.')];
            }

            $items = [];
            foreach ($events as $event) {
                $items[] = [
                    '#markup' => '<strong>' . $event['title'] . '</strong> - ' . $event['start'],
                ];
            }

            return [
                '#theme' => 'item_list',
                '#items' => $items,
                '#cache' => [
                    'max-age' => 3600, // Cache API response for 1 hour
                ],
            ];
        } catch (\Exception $e) {
            return ['#markup' => $this->t('Unable to load events at this time.')];
        }
    }
}
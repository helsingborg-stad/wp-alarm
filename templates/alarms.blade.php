

@card([
    'classList' => [
        $classes
    ]
])
    @if (!$hideTitle && !empty($post_title))
        <h4 class="box-title">{!! apply_filters('the_title', $post_title) !!}</h4>
    @endif

    <div class="c-card__body">
        <div class="box-content">
            <div class="filters hidden" style="display:none;">
                <div class="o-grid">
                    <div class="o-grid-12">
                        <label for="data-alarm-filter-text"><?php _e('Text search', 'api-alarm-integration'); ?></label>

                        @field([
                            'type' => 'text',
                            'attributeList' => [
                                'type' => 'text',
                                'name' => 'text',
                                'data-alarm-filter' => "text",
                                'id' => 'data-alarm-filter-text'
                            ],
                            'label' => translate('Search', 'api-alarm-integration')
                        ])
                        @endfield
                    </div>

                    <div class="o-grid-12">
                        <label for="data-alarm-filter-place"><?php _e('Place', 'api-alarm-integration'); ?></label>

                        <select data-alarm-filter="place" id="data-alarm-filter-place">
                            <option value=""><?php _e('All', 'api-alarm-integration'); ?></option>
                            @foreach ((array) \ApiAlarmIntegration\Module::getPlaces($options['api_url']) as $place)
                                @if (is_object($place))
                                    <option value="{{ $place->id }}">{{ $place->name }}</option>
                                @endif
                            @endforeach
                        </select>  
                    </div>

                    <div class="o-grid-12 o-grid-6@md">
                        <label for="data-alarm-filter-date-from"><?php _e('Date from', 'api-alarm-integration'); ?></label>

                        @field([
                            'type' => 'datepicker',
                            'value' => '',
                            'label' => translate('Date from', 'api-alarm-integration'),
                            'attributeList' => [
                                'type' => 'text',
                                'name' => 'text',
                                'data-invalid-message' => "You need to add a valid date!",
                                'data-alarm-filter' => 'date-from',
                                'id' => 'data-alarm-filter-date-from'
                            ]
                        ])
                        @endfield
                    </div>

                    <div class="o-grid-12 o-grid-6@md">
                        <label for="data-alarm-filter-date-to"><?php _e('Date to', 'api-alarm-integration'); ?></label>

                        @field([
                            'type' => 'datepicker',
                            'value' => '',
                            'label' => translate('Date to', 'api-alarm-integration'),
                            'attributeList' => [
                                'type' => 'text',
                                'name' => 'text',
                                'data-invalid-message' => "You need to add a valid date!",
                                'data-alarm-filter' => 'date-to',
                                'id' => 'data-alarm-filter-date-to'
                            ]
                        ])
                        @endfield
                    </div>

                    <div class="o-grid-12">
                        @button([
                            'text' => translate('Search', 'api-alarm-integration'),
                            'color' => 'primary',
                            'style' => 'filled',
                            'attributeList' => ['data-alarm-filter' => 'search']
                        
                        ])
                        @endbutton
                    </div>
                </div>
            </div>

            @button([
                'text' => translate('Show filters', 'api-alarm-integration'),
                'color' => 'primary',
                'style' => 'filled',
                'attributeList' => ['data-action' => 'api-alarm-integration-toggle-filters']
            
            ])
            @endbutton
        </div>

        <div class="box-content no-padding">
            <ul class="accordion accordion-list accordion-list-small alarms-container" data-api-alarm-integration="load" data-alamrs-per-page="{{ $options['alarms_per_page'] }}" data-alamrs-current-page="0" data-alarm-api="{{ trailingslashit($options['api_url']) }}">
                <li style="padding:20px 0;" data-template="api-alarm-integration-loading" data-api-alarms-load-more>
                
                </li>
                <li class="accordion-section no-padding arrow-trigger" data-template="api-alarm-integration-row" js-toggle-trigger='{# id #}' aria-pressed="false">
                    @icon([
                        'icon' => 'keyboard_arrow_up',
                        'size' => 'md',
                        'attributeList' => [],

                    ])
                    @endicon
                    <label class="accordion-toggle block-level" for="alarm-{# id #}"><span class="link-item link">{## if (typeof data.place[0] != 'undefined') ##}{# place[0].name #}: {## endif ##}{# title.rendered #}</span><time class="date pull-right text-sm text-dark-gray">{# date #}</time></label>
                    <div class="accordion-content u-display--none" js-toggle-item='{# id #}' js-toggle-class="u-display--none" >
                        <table>
                            <tr>
                                <td><strong><?php _e('Time', 'api-alarm-integration'); ?>:</strong></td>
                                <td>{# date #}</td>
                            </tr>
                            <tr>
                                <td><strong><?php _e('Incident', 'api-alarm-integration'); ?>:</strong></td>
                                <td>{# title.rendered #}</td>
                                <td><strong><?php _e('Level', 'api-alarm-integration'); ?>:</strong></td>
                                <td>{# type #}</td>
                            </tr>
                            <tr>
                                <td><strong><?php _e('Address', 'api-alarm-integration'); ?>:</strong></td>
                                <td>{# address #}, {# place[0].name #}</td>

                                <td><strong><?php _e('Station', 'api-alarm-integration'); ?>:</strong></td>
                                <td> {# station.title #}</td>
                            </tr>
                        </table>
                    </div>
                </li>
                <li data-template="api-alarm-integration-load-more" style="padding:10px;" data-api-alarms-load-more>
                    @button([
                        'text' => translate('Show more alarms', 'api-alarm-integration'),
                        'color' => 'primary',
                        'style' => 'filled',
                        'attributeList' => ['data-action' => 'api-alarm-integration-load-more']
                    
                    ])
                    @endbutton
                    
                </li>
            </ul>
        </div>
    </div>
@endcard
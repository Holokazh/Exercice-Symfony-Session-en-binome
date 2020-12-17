<?php

namespace App\EventSubscriber;

use App\Repository\SessionRepository;
use CalendarBundle\CalendarEvents;
use CalendarBundle\Entity\Event;
use CalendarBundle\Event\CalendarEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class CalendarSubscriber implements EventSubscriberInterface
{
    private $sessionRepository;
    private $router;

    public function __construct(
        SessionRepository $sessionRepository,
        UrlGeneratorInterface $router
    ) {
        $this->sessionRepository = $sessionRepository;
        $this->router = $router;
    }

    public static function getSubscribedEvents()
    {
        return [
            CalendarEvents::SET_DATA => 'onCalendarSetData',
        ];
    }

    public function onCalendarSetData(CalendarEvent $calendar)
    {
        $start = $calendar->getStart();
        $end = $calendar->getEnd();
        $filters = $calendar->getFilters();

        // Modify the query to fit to your entity and needs
        // Change session.beginAt by your start date property
        $sessions = $this->sessionRepository
            ->createQueryBuilder('s')
            ->where('s.dateStart BETWEEN :start and :end OR s.dateEnd BETWEEN :start and :end')
            ->setParameter('start', $start->format('Y-m-d H:i:s'))
            ->setParameter('end', $end->format('Y-m-d H:i:s'))
            ->getQuery()
            ->getResult();

        foreach ($sessions as $session) {
            // this create the events with your data (here session data) to fill calendar
            $sessionEvent = new Event(
                $session->getTraining(),
                $session->getDateStart(),
                $session->getDateEnd() // If the end date is null or not defined, a all day event is created.
            );

            /*
             * Add custom options to events
             *
             * For more information see: https://fullcalendar.io/docs/event-object
             * and: https://github.com/fullcalendar/fullcalendar/blob/master/src/core/options.ts
             */

            $sessionEvent->setOptions([
                'backgroundColor' => 'red',
                'borderColor' => 'red',
            ]);
            $sessionEvent->addOption(
                'url',
                $this->router->generate('session_show', [
                    'id' => $session->getId(),
                ])
            );

            // finally, add the event to the CalendarEvent to fill the calendar
            $calendar->addEvent($sessionEvent);
        }
    }
}

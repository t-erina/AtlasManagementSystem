<?php

namespace App\Calendars\General;

use Carbon\Carbon;
use Auth;

class CalendarView
{

  private $carbon;
  function __construct($date)
  {
    $this->carbon = new Carbon($date);
  }

  public function getTitle()
  {
    return $this->carbon->format('Y年n月');
  }

  function render()
  {
    $html = [];
    $html[] = '<div class="calendar text-center">';
    $html[] = '<table class="table">';
    $html[] = '<thead>';
    $html[] = '<tr>';
    $html[] = '<th class="border">月</th>';
    $html[] = '<th class="border">火</th>';
    $html[] = '<th class="border">水</th>';
    $html[] = '<th class="border">木</th>';
    $html[] = '<th class="border">金</th>';
    $html[] = '<th class="border day-sat">土</th>';
    $html[] = '<th class="border day-sun">日</th>';
    $html[] = '</tr>';
    $html[] = '</thead>';
    $html[] = '<tbody>';
    $weeks = $this->getWeeks();
    foreach ($weeks as $week) {
      $html[] = '<tr class="' . $week->getClassName() . '">';

      $days = $week->getDays();
      foreach ($days as $day) {
        $startDay = $this->carbon->copy()->format("Y-m-01");
        $toDay = $this->carbon->copy()->format("Y-m-d");

        if ($startDay <= $day->everyDay() && $toDay > $day->everyDay()) {
          //クラス名　過去の日付
          $html[] = '<td class="calendar-td past-day border ' . $day->getClassName() . '">';
        } else {
          //クラス名　今日以降の日付
          $html[] = '<td class="calendar-td border ' . $day->getClassName() . '">';
        }
        $html[] = $day->render();

        //予約あり
        if (in_array($day->everyDay(), $day->authReserveDay())) {
          $reservePart = $day->authReserveDate($day->everyDay())->first()->setting_part;
          if ($reservePart == 1) {
            $reservePart = "リモ1部";
          } else if ($reservePart == 2) {
            $reservePart = "リモ2部";
          } else if ($reservePart == 3) {
            $reservePart = "リモ3部";
          }
          if ($startDay <= $day->everyDay() && $toDay > $day->everyDay()) {
            //過去の日付
            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px">' . $reservePart . '</p>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          } else {
            //今日以降の日付
            $html[] = '<button type="submit" class="js_delete_date btn btn-danger p-0 w-75" name="delete_date[]" style="font-size:12px" value="' . $day->authReserveDate($day->everyDay())->first()->setting_reserve . '" data-time="' . $reservePart . '" data-id="' . $day->authReserveDate($day->everyDay())->first()->id . '">' . $reservePart . '</button>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          }
        } else {
          //予約なし
          if ($startDay <= $day->everyDay() && $toDay > $day->everyDay()) {
            //過去の日付
            $html[] = '<p class="m-auto p-0 w-75" style="font-size:12px; color:#333;">受付終了</p>';
            $html[] = '<input type="hidden" name="getPart[]" value="" form="reserveParts">';
          } else {
            //今日以降の日付
            $html[] = $day->selectPart($day->everyDay());
          }
        }
        $html[] = $day->getDate();
        $html[] = '</td>';
      }
      $html[] = '</tr>';
    }
    $html[] = '</tbody>';
    $html[] = '</table>';
    $html[] = '</div>';

    //モーダル =================================
    $html[] = '<div class="modal">';
    $html[] = '<div class="modal__bg">';
    $html[] = '<div class="modal__content">';
    $html[] = '<div><span>予約日：</span><label class="modal_date"></label></div>';
    $html[] = '<div><span>時間：</span><label class="modal_time"></label></div>';
    $html[] = '<span>上記の予約をキャンセルしてもよろしいですか？</span>';
    $html[] = '<div class="modal_btn_wrapper">';
    $html[] = '<input type="submit" class="js_modal_btn btn btn-primary" value="閉じる" form="">';
    $html[] = '<input type="submit" class="js_modal_btn btn btn-danger" value="キャンセル" form="deleteParts">';
    $html[] = '<input type="hidden" class="delete_id" name="delete_id" value="" form="deleteParts">';
    $html[] = '</div>';
    $html[] = '</div>';
    $html[] = '</div>';
    $html[] = '</div>';
    //==========================================

    $html[] = '<form action="/reserve/calendar" method="post" id="reserveParts">' . csrf_field() . '</form>';
    $html[] = '<form action="/delete/calendar" method="post" id="deleteParts">' . csrf_field() . '</form>';
    return implode('', $html);
  }

  protected function getWeeks()
  {
    $weeks = [];
    $firstDay = $this->carbon->copy()->firstOfMonth();
    $lastDay = $this->carbon->copy()->lastOfMonth();
    $week = new CalendarWeek($firstDay->copy());
    $weeks[] = $week;
    $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();
    while ($tmpDay->lte($lastDay)) {
      $week = new CalendarWeek($tmpDay, count($weeks));
      $weeks[] = $week;
      $tmpDay->addDay(7);
    }
    return $weeks;
  }
}

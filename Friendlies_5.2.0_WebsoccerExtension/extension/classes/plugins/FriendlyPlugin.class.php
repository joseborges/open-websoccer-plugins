<?php
/******************************************************

  Friendly module for HSE WebSoccer-Sim

  Copyright (c) 2014 by

  Pierre Keutel
  EMail: pierre.keutel@yahoo.fr
  Homepage: 
  
  Version: 5.2.0

******************************************************/

/**
 * @author Pierre Keutel
 * Adds bonuses for friendlies
 */
class FriendlyPlugin {
	
	/**
	 * .
	 * 
	 * @param MatchCompletedEvent $event event.
	 */
	public static function handleBonusAfterFriendlyCompleted(MatchCompletedEvent $event) {
		
		// only consider friendlies
		if (($event->match->type == 'Freundschaft') 
		&& (!$event->match->homeTeam->isNationalTeam || !$event->match->guestTeam->isNationalTeam)
		&& ($event->websoccer->getConfig("friendlies_bonus"))) {
		
			$homeTeamId = $event->match->homeTeam->id;
			$homeTeamGoals  = $event->match->homeTeam->getGoals();
			$guestTeamId = $event->match->guestTeam->id;
			$guestTeamGoals = $event->match->guestTeam->getGoals();
			
			$bonusWin  = $event->websoccer->getConfig("friendlies_bonus_win");
			$bonusDraw = $event->websoccer->getConfig("friendlies_bonus_draw");
			$bonusLoss = $event->websoccer->getConfig("friendlies_bonus_loss");
			
			//convert bonus to positiv => only accepted for Loss
			$bonusWin = abs($bonusWin);
			$bonusDraw = abs($bonusDraw);
			
			if ($homeTeamGoals > $guestTeamGoals) {
				BankAccountDataService::creditAmount($event->websoccer, $event->db, $homeTeamId, $bonusWin, 
				'friendly_bonus_win_subject', 'friendly_sender_subject');
				if($bonusLoss < 0) {
					BankAccountDataService::debitAmount($event->websoccer, $event->db, $guestTeamId, abs($bonusLoss),
					'friendly_bonus_loss_subject', 'friendly_sender_subject');
				}
				else {
					BankAccountDataService::creditAmount($event->websoccer, $event->db, $guestTeamId, $bonusLoss, 
					'friendly_bonus_loss_subject', 'friendly_sender_subject');
				}
			} elseif ($homeTeamGoals == $guestTeamGoals) {
				BankAccountDataService::creditAmount($event->websoccer, $event->db, $homeTeamId, $bonusDraw, 
				'friendly_bonus_draw_subject', 'friendly_sender_subject');
				BankAccountDataService::creditAmount($event->websoccer, $event->db, $guestTeamId, $bonusDraw, 
				'friendly_bonus_draw_subject', 'friendly_sender_subject');
			} elseif ($homeTeamGoals < $guestTeamGoals) {
				if($bonusLoss < 0) {
					BankAccountDataService::debitAmount($event->websoccer, $event->db, $homeTeamId, abs($bonusLoss),
					'friendly_bonus_loss_subject', 'friendly_sender_subject');
				}
				else {
					BankAccountDataService::creditAmount($event->websoccer, $event->db, $homeTeamId, $bonusLoss, 
					'friendly_bonus_loss_subject', 'friendly_sender_subject');
				}
				BankAccountDataService::creditAmount($event->websoccer, $event->db, $guestTeamId, $bonusWin, 
				'friendly_bonus_win_subject', 'friendly_sender_subject');
			}
		}
		else {
			return;
		}
	}
}
?>
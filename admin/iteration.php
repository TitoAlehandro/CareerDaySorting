<?php
require_once "db.php";

function attemptSchedule($scheduledCareers, $newCareerID, $student, $careers, &$itsRan, $isChoice = true)
{
	foreach ( $student->placements as $k => $placement )
	{
		if ( $placement->id != 0 )
			$careers[$placement->id]->removeFromBlock($k);
	}
	
	$thisStudentSortSuccess = false;
	for ( $_a = 0; $_a < 3; $_a++ )
	{
		$a = $_a;
		if ( $scheduledCareers[0]->isStatic() ) // Don't move static events!
			$a = 0;
		for ( $_b = 0; $_b < 3; $_b++ )
		{
			$b = $_b;
			if ( $scheduledCareers[1]->isStatic() ) // Don't move static events!
				$b = 1;
			for ( $_c = 0; $_c < 3; $_c++ )
			{
				$c = $_c;
				if ( $scheduledCareers[2]->isStatic() ) // Don't move static events!
					$c = 2;
											
				if ( uniqueIteration($a, $b, $c) )
				{
					$itsRan++;
					$invalid = false;
					//echo "In This Iteration: ".$a." - ".$b." - ".$c."\n";
					$thisScheduleIteration = array($a=>$scheduledCareers[0], $b => $scheduledCareers[1], $c => $scheduledCareers[2]);	
											
					for ($k = 0; $k < 3; $k++ )
					{
						$careerObj = $thisScheduleIteration[$k];
						$blockNum = $k;
						$careerID = 0;
						if ( is_object($careerObj) )
							$careerID = $careerObj->id;
						if ( $careerID != 0 )
						{
							if ( $careers[$careerID]->blockIsFull($blockNum) )
								$invalid = true;
						}
											
					}
					if ( !$invalid )
					{
						$thisStudentSortSuccess = true;
						$student->placements = $thisScheduleIteration;									
						break;
					}
				}
										
			}
			if ( $thisStudentSortSuccess ) break;
		}
		if ( $thisStudentSortSuccess ) break;
	}
							
	if ( !$thisStudentSortSuccess && $isChoice )
	{
		$student->choices[$highestChoiceNumber]->possible = false;
	}
	
	foreach ( $student->placements as $k => $placement )
	{
		if ( $placement->id != 0 )
			$careers[$placement->id]->addToBlock($k);
	}
	
	return $thisStudentSortSuccess;
}
?>
<?php

function get_missed_number( $sequence ) {
	$result = false;

	if ( is_array($sequence) ) {
		$len = count($sequence);

		if ( $len == 2 ) {
			$result = $sequence[0] + ($sequence[1] - $sequence[0]) / 2;
		} elseif ($len > 2) {
			$d = 0;                            // постоянное число последовательности
			
			for ($i=0; $i < $len - 2; $i++) { 
				$a  = $sequence[$i];             // текущий член последовательности
				$a1 = $sequence[$i+1];           // следуюий член последовательности
				$a2 = $sequence[$i+2];           // следуюий следующего члена последовательности
				
				$diff1 = $a1 - $a;
				$diff2 = $a2 - $a1;
				
				if ( ($diff1 == 0) || ($diff2 == 0) ) 
					break;

				if ( $diff1 == $diff2 ) {
					$d = $diff1;
					continue;
				} elseif ( $diff1 > $diff2 )
					return  $a + $diff1 / 2;
				else 
					return $a1 + $diff2 / 2;
			}
		}
	}

	return $result;
}
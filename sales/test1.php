<?php
$query3 = "SELECT SUM(zbracket) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$query4 = "SELECT SUM(minilockcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
                <td align=center><u><font size=5 face = "Arial"><b>Scope of Work/Sale Summary</b></u></td> 
$query17 = "SELECT SUM(doorunitcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$sum = ($wmu+ $owmu + $sowmu); 
$basesum = ($sum + $equip7['SUM(doorunitcount)']); 
//echo $basesum; 
        if($basesum < 60) 
        if($basesum  > 59) 
                $baseunitx = ceil($basesum/ 60); 
        if($basesum < 60) 
        if($basesum > 59) 
                $baseunitx = ceil($basesum / 60); 
$query8 = "SELECT SUM(pircount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
$query9 = "SELECT SUM(reedswitchcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
if(!((($row9['SUM(reedswitchcount)'] == 0) && ($row8['SUM(pircount)'] == 0)) && ($twatch == 0))) 
        if(!(($row9['SUM(reedswitchcount)'] == 0) && ($row8['SUM(pircount)'] == 0))) 
        if($equip7['SUM(doorunitcount)']<>0) 
                        <?php echo $equip7['SUM(doorunitcount)']; ?> 
        $query6 = "SELECT SUM(outdoordoorunitCount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
        if(!$row6['SUM(outdoordoorunitCount)']==0) 
                        Outdoor Units:<?php echo $row6['SUM(outdoordoorunitCount)']; ?> 
        $query7 = "SELECT SUM(utcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
        if(!$row7['SUM(utcount)']==0) 
                Universal Transmitters: <?php echo $row7['SUM(utcount)'] ?> 
        if(!$row9['SUM(reedswitchcount)']==0) 
                                Reed Switches: <?php echo $row9['SUM(reedswitchcount)']; ?> 
        $query12 = "SELECT SUM(outdoorreedcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
        if(!$equip2['SUM(outdoorreedcount)']==0) 
                        Outdoor Reed Switches: <?php $equip2['SUM(outdoorreedcount)']; ?> 
        if(!$row8['SUM(pircount)']==0) 
                                Passive Infared Detectors: <?php $row8['SUM(pircount)']; ?> 
        $query10 = "SELECT SUM(keypadcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
        if(!$equip0['SUM(keypadcount)']==0) 
                Keypads: <?php echo $equip0['SUM(keypadcount)']; ?> 
        $query11 = "SELECT SUM(pushbuttoncount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
        if(!$equip1['SUM(pushbuttoncount)']==0) 
                        Pushbuttons: <?php echo $equip1['SUM(pushbuttoncount)']; ?> 
        $query13 = "SELECT SUM(timercount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
        if(!$equip3['SUM(timercount)']==0) 
                        Timers: <?php echo $equip3['SUM(timercount)']; ?> 
        $query14 = "SELECT SUM(minilockcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
        if(!$equip4['SUM(minilockcount)']==0) 
                Mini Locks: <?php echo $equip4['SUM(minilockcount)'] ?> 
        $query5 = "SELECT SUM(zbracket) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
        if(!$row5['SUM(zbracket)']==0) 
                                Z Bracket Locks: <?php echo $row5['SUM(zbracket)'] ?> 
        $query177 = "SELECT SUM(zbracketoutdoor) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
        if(!$equip77['SUM(zbracketoutdoor)']==0) 
                                Outdoor Z Bracket Locks: <?php echo $equip77['SUM(zbracketoutdoor)'] ?> 
        $query178 = "SELECT SUM(egresskit) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
        if(!$equip78['SUM(egresskit)']==0) 
                        Egress Kits: <?php echo $equip78['SUM(egresskit)']; ?> 
        $query16 = "SELECT SUM(relaycount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
        if(!$equip6['SUM(relaycount)']==0) 
                        Deactivation Relays: <?php echo $equip6['SUM(relaycount)'] ?> 
        $query15 = "SELECT SUM(racepackcount) FROM tblfacilitydoors WHERE FacilityID='$f_id'"; 
        if(!$equip5['SUM(racepackcount)']==0) 
                        Raceway Packs: <?php echo $equip5['SUM(racepackcount)'] ?> 
        if(($equip4['SUM(minilockcount)'] > 0) OR ($row5['SUM(zbracket)'] > 0) OR ($equip77['SUM(zbracketoutdoor)']> 0) OR ($row82 > 0) OR ($row83 > 0))

                if(!(($equip4['SUM(minilockcount)']==0) && ($row5['SUM(zbracket)']==0) && ($equip77['SUM(zbracketoutdoor)']==0)))

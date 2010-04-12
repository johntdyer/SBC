<?php
header("Content-type: text/xml");
header('Cache-Control: no-cache');
echo '<?xml version="1.0" encoding="UTF-8"?>';
echo "<callxml version=\"3.0\">";?>

<!-- Random Function to get values for pin -->
<assign var="random" expr="random(3)"/>
<log expr="'*****Random Value: $random;'"/>

	<if test="$random;=0">
		<assign var="calerID" value="4074740000"/>
		<log expr="'******Phone: $Phone; ' "/>
	</if>

	<if test="$random;=1">		
		<assign var="calerID" value="4074740001"/>
		<log expr="'******Phone: $Phone; ' "/>
	</if>

	<if test="$random;=2">
		<assign var="calerID" value="4074740002"/>
		<log expr="'******Phone: $Phone; '"/>
	</if>



<assign var="numberToDial" value="sip:sbc@127.0.0.1"/>
<!-- <assign var="phone" value="14074740214"/> -->
<assign var="epoch" value="1000"/>

 <assign var="sessionID" value="$session.ID;"/>

	<block label="firstBlock">
	
		<log expr="'@@@@@@@@@@@@@'"/>
		<log expr="'@@@ First Block  @@@'"/>
		<log expr="'@@@@@@@@@@@@@'"/>

		<call value="$numberToDial;" callerID="$calerID;" maxtime="120s"/>
		<log expr="'@@@ Calling $Phone;'"/>

		<on event="answer">
	  		<assign var="startTime" expr="time()"/>

			<log expr="'@@@@@@@@@@@@@@@'"/>
			<log expr="'@@@ Call Answered  @@@'"/>
			<log expr="'@@@@@@@@@@@@@@@'"/>
			
			<do label="MessageBlock">
				<wait value="10s"/>
				<log expr="'Key in * to catcher'"/>
				<playdtmf value="*"/>
				<wait value="5s"/>
				
				<goto value="#secondBlock"/>
			</do>
		</on>

  		<on event="callfailure">
			<log expr="'@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@'"/>
			<log value="'@@@ Call failed to connect to $numberToDial; @@@@"/>
			<log expr="'@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@@'"/>
			<exit/>
		</on>
	</block>

	<block label="secondBlock">
			<log expr="'@@@@@@@@@@@@@'"/>
			<log expr="'@@@ SecondBlock @@@'"/>
			<log expr="'@@@@@@@@@@@@@'"/>
		<wait value="2"/>
		<log expr="'@@@@@@@@@@@@@'"/>
		<log expr="' ENDING CALL  ' "/>
		<log expr="'@@@@@@@@@@@@@'"/>
	 
		<goto value="#normalEnd"/>
	</block>
	
	<block label="normalEnd">
	  	<assign var="endTime" expr="time()"/>
	  	<assign var="callDuration" expr="$endTime; - $startTime;"/>
	
			<log> @@@@@@ Normal End: $callDuration; Seconds @@@@@@ </log>
		<exit/>
	</block>
	
	<onhangup>
	<log expr="'@@@@ Something happened, submit data'"/>
	
		<log value="*************Call Duration: $session.LastCallDuration; ************"/>
		<assign var="callDuration" expr="$session.LastCallDuration; div $epoch;"/>
		<goto value="#submitData"/>
	</onhangup>
	
	<block label="submitData">
		<log expr="'@@@@@@@@@@@@'"/>
		<log expr="'@@@@ SUBMIT DATA'"/>
		<log expr="'@@@@@@@@@@@@'"/>
		<fetch var="foo" value="catcher.php" submit="sessionID, callDuration" method="GET"/>
  <exit/>
	</block>
</callxml>

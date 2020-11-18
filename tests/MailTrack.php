<?php
namespace Tests;

use Swift_Events_EventListener;
use Swift_Message;
use Illuminate\Support\Facades\Mail;

trait MailTrack{
    
    protected $emails = [];
    
    /** @before */
    public function setUpMailTracking()
    {
    	parent::setUp();
        Mail::getSwiftMailer()->registerPlugin(new TestingMailEventListerner($this));
        
    }
    
    public function seeEmailsSent($count)
    {
        $emailsSent = count($this->emails);
        
        $this->assertCount($count,
                        $this->emails,
                        "The number of sent messages $emailsSent is different from expected 2"
                        );
        
        return $this;
    }
    
    public function seeEmailWasSent()
    {
        $this->assertNotEmpty(
            $this->emails,
            "No emails have been sent"
        );
        
        return $this;
    }
    
    public function seeEmailWasNotSent()
    {
    	$this->assertEmpty(
    					$this->emails,
    					"Did not expect any emails to have been sent"
    					);
    	
    	return $this;
    }
    
    public function seeEmailEquals($body, Swift_Message $message = null){
    	
    	$this->assertEquals(
    		$body, 
    		$this->getMessage($message)->getBody(),
    		"No email with the provided body was sent"
    	);
    	
    	return $this;
    
    }
    
    public function seeEmailContains($exerpt, Swift_Message $message = null){
    	
    	$this->assertStringContainsString(
    					$exerpt,
    					$this->getMessage($message)->getBody(),
    					"No email containing provided body was sent"
    					);
    	
    	return $this;
    	
    }
    
    public function seeEmailSentTo($recipient, Swift_Message $message = null){
    	
    	$lastEmail= $this->getMessage($message);
    	
    	
    	$this->assertArrayHasKey(
    					$recipient, 
    					$lastEmail->getTo(),
    					"No email was sent to recipient $recipient");
    	
    	return $this;
    }
    
    public function seeEmailSentFrom($sender, Swift_Message $message = null){
    	
    	$lastEmail= $this->getMessage($message);
    	
    	
    	$this->assertArrayHasKey(
    			$sender,
    			$lastEmail->getFrom(),
    			"No email was sent from $sender"
    	);
    					
    	return $this;
    }

    private function getMessage(Swift_Message $message = null){
    	
    	$this->seeEmailWasSent();
    	
    	return $message ?: $this->LastEmail();
    	
    }
    
    private function lastEmail(){
    	
    	return end($this->emails);
    	
    }
    
    public function addEmail(Swift_Message $message)
    {
    	$this->emails[] = $message;
    }
}

class TestingMailEventListerner implements Swift_Events_EventListener{
    
    protected $test;
    
    public function __construct($test)
    {
        $this->test = $test;
    }
    
    public function beforeSendPerformed($event)
    {
        $message = $event->getMessage();
        
        $this->test->addEmail($message);
        
    }
}
?>
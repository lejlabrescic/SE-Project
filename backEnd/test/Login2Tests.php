<?php
//require '../modules/auth/login.php';
require '../vendor/autoload.php';
use PHPUnit\Framework\TestCase; 
class LoginTest extends TestCase
{
    public function testLoginSuccess()
    {
        $dbMock = $this->getMockBuilder(PDO::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $stmtMock = $this->getMockBuilder(PDOStatement::class)
            ->getMock();
        
        $fetchResult = array(
            'id' => 1,
            'fullName' => 'test',
            'role' => 'user',
            'password' => password_hash('test', PASSWORD_DEFAULT) 
        );
        
        $dbMock->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo("SELECT * FROM `registration` WHERE `email` = :email"))
            ->willReturn($stmtMock);
        
        $stmtMock->expects($this->once())
            ->method('bindParam')
            ->with($this->equalTo(':email'), $this->equalTo('test@example.com'), $this->equalTo(PDO::PARAM_STR));
        
        $stmtMock->expects($this->once())
            ->method('execute');
        
        $stmtMock->expects($this->once())
            ->method('fetch')
            ->with($this->equalTo(PDO::FETCH_ASSOC))
            ->willReturn($fetchResult);
        
        $sessionMock = $this->getMockBuilder(stdClass::class)
            ->setMethods(['__set'])
            ->getMock();
        
        $sessionMock->expects($this->once())
            ->method('__set')
            ->with($this->equalTo('user_id'), $this->equalTo(1));
        
        $GLOBALS['_SESSION'] = $sessionMock;
        
        ob_start();
        loginUser('test@example.com', 'password123');
        $output = ob_get_clean();
        
+        $expectedOutput = json_encode(array(
            "success" => true,
            "message" => "Login successful. Welcome, John Doe!",
            "userId" => 1,
            "role" => "user"
        ));
        
        $this->assertEquals($expectedOutput, $output);
    }
    
    public function testLoginFailure()
    {
        $dbMock = $this->getMockBuilder(PDO::class)
            ->disableOriginalConstructor()
            ->getMock();
        
        $stmtMock = $this->getMockBuilder(PDOStatement::class)
            ->getMock();
        
        $dbMock->expects($this->once())
            ->method('prepare')
            ->with($this->equalTo("SELECT * FROM `registration` WHERE `email` = :email"))
            ->willReturn($stmtMock);
        
        $stmtMock->expects($this->once())
            ->method('bindParam')
            ->with($this->equalTo(':email'), $this->equalTo('test@yahoo.com'), $this->equalTo(PDO::PARAM_STR));
        
        $stmtMock->expects($this->once())
            ->method('execute');
        
        $stmtMock->expects($this->once())
            ->method('rowCount')
            ->willReturn(0);
        
        ob_start();
        loginUser('test@yahoo.com', 'test');
        $output = ob_get_clean();
        
        $expectedOutput = json_encode(array(
            "success" => false,
            "message" => "User not found. Please check your email."
        ));
        
        $this->assertEquals($expectedOutput, $output);
    }
}

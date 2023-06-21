<?php
require '../vendor/autoload.php';
use PHPUnit\Framework\TestCase;

class RegistrationTest extends TestCase{
    public function testRegisterUser(){
        $mockDb = $this->getMockBuilder(PDO::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mockStmt = $this->getMockBuilder(PDOStatement::class)
            ->getMock();
        $mockStmt->expects($this->once())
            ->method('fetchColumn')
            ->willReturn(0);
        $mockStmt->expects($this->once())
            ->method('closeCursor');
        $mockDb->expects($this->exactly(2))
            ->method('prepare')
            ->will($this->returnValue($mockStmt));

        $this->getMockBuilder('Registration')
            ->setMethods(['getDatabaseConnection'])
            ->getMock();

        $registration = new Registration();

        $reflection = new ReflectionClass($registration);
        $method = $reflection->getMethod('getDatabaseConnection');
        $method->setAccessible(true);
        $method->setValue($registration, $mockDb);

        $username = 'Test';
        $email = 'testtestic@gmail.com';
        $password = 'test';
        $confirmPassword = 'test';
        $user = 'user';

        ob_start();
        $registration->registerUser($username, $email, $password, $confirmPassword, $user);
        $output = ob_get_contents();
        ob_end_clean();

        $expectedOutput = json_encode(array("success" => true, "message" => "Registration successful. Welcome, $username!"));
        $this->assertEquals($expectedOutput, $output);
    }
}

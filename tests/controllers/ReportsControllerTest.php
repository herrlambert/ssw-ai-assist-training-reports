<?php
use PHPUnit\Framework\TestCase;

class ReportsControllerTest extends TestCase
{
    private $controller;
    private $testCsvPath;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new ReportsController();
        
        // Create a temporary test CSV file
        $this->testCsvPath = sys_get_temp_dir() . '/test_training_activities.csv';
        $testData = [
            ['FirstName', 'LastName', 'Identifier', 'Title', 'ParticipationDate'],
            ['John', 'Doe', 'JD123', 'Safety Training', '2023-01-15'],
            ['Jane', 'Smith', 'JS456', 'Safety Training', '2021-01-10'],
            ['Bob', 'Wilson', 'BW789', 'First Aid', '2023-06-20'],
            ['Alice', 'Brown', 'AB101', 'Safety Training', '2020-05-15']
        ];

        $fp = fopen($this->testCsvPath, 'w');
        foreach ($testData as $row) {
            fputcsv($fp, $row);
        }
        fclose($fp);

        // Set the APP_ROOT constant if not already set
        if (!defined('APP_ROOT')) {
            define('APP_ROOT', dirname(__DIR__));
        }
    }

    protected function tearDown(): void
    {
        // Clean up the test CSV file
        if (file_exists($this->testCsvPath)) {
            unlink($this->testCsvPath);
        }
        parent::tearDown();
    }

    public function testByPersonWithValidSearch()
    {
        // Simulate GET parameter
        $_GET['search'] = 'John';
        
        // Start output buffering to capture any output
        ob_start();
        $this->controller->byPerson();
        $output = ob_get_clean();

        // Assert that the output contains expected data
        $this->assertStringContainsString('John', $output);
        $this->assertStringContainsString('Doe', $output);
        $this->assertStringContainsString('JD123', $output);
    }

    public function testByPersonWithNoResults()
    {
        $_GET['search'] = 'NonexistentPerson';
        
        ob_start();
        $this->controller->byPerson();
        $output = ob_get_clean();

        $this->assertStringContainsString('No training records found for your search', $output);
    }

    public function testByPersonWithEmptySearch()
    {
        $_GET['search'] = '';
        
        ob_start();
        $this->controller->byPerson();
        $output = ob_get_clean();

        $this->assertStringContainsString('Please enter a search term to find training records', $output);
    }

    public function testExpiredWithSelectedTraining()
    {
        $_GET['training'] = 'Safety Training';
        
        ob_start();
        $this->controller->expired();
        $output = ob_get_clean();

        // Should show Jane Smith and Alice Brown as expired
        $this->assertStringContainsString('Jane', $output);
        $this->assertStringContainsString('Smith', $output);
        $this->assertStringContainsString('Alice', $output);
        $this->assertStringContainsString('Brown', $output);
        // Should not show John Doe (not expired)
        $this->assertStringNotContainsString('John', $output);
        $this->assertStringNotContainsString('Doe', $output);
    }

    public function testExpiredWithNoSelection()
    {
        $_GET['training'] = '';
        
        ob_start();
        $this->controller->expired();
        $output = ob_get_clean();

        // Should show the training selection form
        $this->assertStringContainsString('Select a Training...', $output);
        $this->assertStringContainsString('Safety Training', $output);
        $this->assertStringContainsString('First Aid', $output);
    }

    public function testExpiredWithNonExistentTraining()
    {
        $_GET['training'] = 'NonexistentTraining';
        
        ob_start();
        $this->controller->expired();
        $output = ob_get_clean();

        $this->assertStringContainsString('No expired trainings found for the selected training', $output);
    }

    public function testFileNotFoundError()
    {
        // Delete the test file to simulate missing file
        if (file_exists($this->testCsvPath)) {
            unlink($this->testCsvPath);
        }

        ob_start();
        $this->controller->byPerson();
        $output = ob_get_clean();

        $this->assertStringContainsString('An error occurred while retrieving the report', $output);
    }
}
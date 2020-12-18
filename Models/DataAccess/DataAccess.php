<?php
namespace DataAccess;
use PDO;

/**
 * Abstract interface to the database.
 * @author Vince <vincent.boursier@gmail.com>
 */
abstract class DataAccess
{
	const VALUES_DELIMITER = ';';
	const INT_MIN = -2147483648;

	protected $pdo;

	public function __construct(PDO $pdo)
	{
		$this->pdo = $pdo;
		date_default_timezone_set('UTC');
	}

	abstract static function getTableSchema();
	abstract public function insertData($filePath);

	protected function createDatabase()
	{
		//TODO: check if tables schema are up to date else upgrade it

		$this->createTable(Category::getTableSchema());

		$this->createTable(User::getTableSchema());
		$this->createTable(Tag::getTableSchema());

		$this->createTable(Location::getTableSchema());
		$this->createTable(Company::getTableSchema());
		$this->createTable(SocialMedia::getTableSchema());
		$this->createTable(Image::getTableSchema());

		(new Location($this->pdo))->insertData(__DIR__ . '/default data/location.tsv');
		(new Tag($this->pdo))->insertData(__DIR__ . '/default data/tag.tsv');
		(new Company($this->pdo))->insertData(__DIR__ . '/default data/company.tsv');
		(new SocialMedia($this->pdo))->insertData( __DIR__ . '/default data/socialmedia.tsv');
		(new User($this->pdo))->insertData(__DIR__ . '/default data/user.tsv');
	}

	private function createTable($sql)
	{
		switch ($this->pdo->getAttribute(PDO::ATTR_DRIVER_NAME))
		{
			case 'oci':
				$this->pdo->exec(str_replace(
					['tinyint', 'bigint'],
					['number(3)', 'number(19)'],
					$sql));
				break;

			case 'mysql':
				$this->pdo->exec($sql);
				break;

			default:
				$this->pdo->exec(str_replace('tinyint', 'smallint', $sql));
				break;
		}
	}

	protected function importData($filePath, $tableName, $columns)
	{
		$preparedStatement = $this->pdo->prepare(
			'insert into ' . $tableName . ' ('
			. implode(',', array_keys($columns)) . ') values (?' . str_repeat(',?', count($columns) -1) . ')'
		);

		$file = fopen($filePath, 'r');
		fgets($file);  // ignore the first line (column header)

		while ($line = fgets($file))
		{
			$values = explode("\t", $line);
			$i = 0;

			foreach ($columns as $columnType)
			{
				$value = trim($values[$i]);

				if ($columnType != PDO::PARAM_STR && $value == '')
				{ $preparedStatement->bindValue($i+1, null, $columnType); }
				elseif ($columnType == PDO::PARAM_LOB)
				{ $preparedStatement->bindValue($i+1, hex2bin($value), $columnType); }
				else
				{ $preparedStatement->bindValue($i+1, $value, $columnType); }

				++$i;
			}

			$preparedStatement->execute();
		}

		fclose($file);
	}
}
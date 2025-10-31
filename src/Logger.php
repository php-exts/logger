<?php
declare (strict_types = 1);

namespace Zeus;

use DateTimeZone;

use Monolog\Level;
use Monolog\Registry;
use Monolog\SignalHandler;

use Monolog\Handler\CouchDBHandler;
use Monolog\Handler\ElasticaHandler;
use Monolog\Handler\ElasticsearchHandler;
use Monolog\Handler\MongoDBHandler;
use Monolog\Handler\NullHandler;
use Monolog\Handler\RedisHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\SocketHandler;

use Monolog\Formatter\LineFormatter;

use Monolog\Processor\LoadAverageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\ProcessIdProcessor;
use Monolog\Processor\HostnameProcessor;
use Monolog\Processor\WebProcessor;

use Zeus\Exception\InvalidArgumentException;

/**
 * Zeus Logger
 *
 * @author imxieke <oss@live.hk>
 * @copyright (c) 2025 CloudFlying
 * @date 2025/08/28 13:20:04
 */
class Logger extends \Monolog\Logger
{
    /**
     * Logger Level
     *
     * @var
     * @author CloudFlying
     * @date 2025/08/27 22:18:02
     */
    protected $level = Level::Debug;

    protected array $handlers = [];

    /**
     * Logger Config
     *
     * @var array
     * @author CloudFlying
     * @date 2025/10/31 10:52:12
     */
    protected array $options = [
        'name' => 'zeus',
        'max' => 0,
        'permission' => 0644,
        'path' => '',
        'lock' => false,
        'level' => Level::Debug,
        'processors' => [],
        'handlers' => [],
        'timezone' => 'Asia/Shanghai',
        'output_date_format' => 'Y-m-d H:i:s',
        'output_format' => "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n",
        'log_date_format' => RotatingFileHandler::FILE_PER_DAY,
        'file_format' => "{filename}-{date}"
    ];

    /**
     * Logger Construct
     *
     * @param array $options
     * @author imxieke <oss@live.hk>
     * @date 2025/10/31 10:52:37
     */
    public function __construct(array $options = [])
    {
        $this->options = array_merge($this->options, $options);
        if (!empty($this->options['path'])) {
            if (!is_dir(dirname($this->options['path']))) {
                throw new \InvalidArgumentException("Log path not exist");
            }
        }
        $this->options['timezone'] = new DateTimeZone($this->options['timezone']);
        $this->processors = [
                new LoadAverageProcessor,
                new MemoryUsageProcessor,
                new MemoryPeakUsageProcessor,
                new IntrospectionProcessor,
                new ProcessIdProcessor,
                new HostnameProcessor,
                new WebProcessor,
        ];
        $this->processors = array_merge($this->processors, $this->options['processors']);
        $this->handlers = array_merge($this->handlers, $this->options['handlers']);
        $handler = new RotatingFileHandler(
            $this->options['path'],
            $this->options['max'],
            $this->options['level'],
            true,
            $this->options['permission'],
            $this->options['lock'],
            $this->options['log_date_format'],
            $this->options['file_format']
        );
        $formatter = new LineFormatter(
            $this->options['output_format'],
            $this->options['output_date_format']
        );
        $handler->setFormatter($formatter);
        $this->pushHandler($handler);
        parent::__construct(
            $this->options['name'],
            $this->handlers,
            $this->processors,
            $this->options['timezone']
        );
    }
}

<?php namespace Impero\Services\Service\Connection;

use Exception;
use Impero\Servers\Record\Server;
use Throwable;

/**
 * Class SshConnection
 *
 * @package Impero\Services\Service\Connection
 */
class SshConnection implements ConnectionInterface, Connectable
{

    /**
     * @var resource
     */
    protected $connection;

    /**
     * @var
     */
    protected $tunnel;

    /**
     * @var
     */
    protected $tunnelPort;

    /**
     * @var
     */
    protected $port;

    /**
     * @var
     */
    protected $user;

    /**
     * @var
     */
    protected $host;

    /**
     * @var
     */
    protected $key;

    /**
     * @var Server
     */
    protected $server;

    /**
     * @var null
     */
    protected $ssh2Sftp = null;

    /**
     * SshConnection constructor.
     *
     * @param Server $server
     * @param        $host
     * @param        $user
     * @param        $port
     * @param        $key
     * @param string $type
     *
     * @throws Exception
     */
    public function __construct(Server $server, $host, $user, $port, $key, $type = 'key')
    {
        $this->server = $server;

        $this->server->logCommand('Opening connection', null, null, null);

        $this->port = $port;
        $this->host = $host;
        $this->user = $user;
        $this->key = $key;
        /**
         * Create connection.
         */
        $this->connection = ssh2_connect($host, $port);

        if (!$this->connection) {
            $this->server->logCommand('Cannot open connection', null, null, null);
            throw new Exception('Cannot estamblish SSH connection');
        } else {
            $this->server->logCommand('Connection opened', null, null, null);
        }

        /**
         * Fingerprint check.
         */
        if ($type == 'key') {
            $keygen = null;
            $command = 'ssh-keygen -lf ' . $key . '.pub -E MD5';
            exec($command, $keygen);
            $keygen = $keygen[0] ?? null;
            $fingerprint = ssh2_fingerprint($this->connection, SSH2_FINGERPRINT_MD5 | SSH2_FINGERPRINT_HEX);
            $publicKeyContent = file_get_contents($key . '.pub');
            $content = explode(' ', $publicKeyContent, 3);
            $calculated = join(':', str_split(md5(base64_decode($content[1])), 2));

            if (!strpos($keygen, $calculated) || $fingerprint != $keygen) {
                //d("Wrong server fingerprint");
            }
        }

        /**
         * Authenticate with public and private key.
         */
        if ($type == 'key') {
            if (!is_readable($key . '.pub')) {
                $this->server->logCommand('Not readable public key: ' . $key . '.pub', null, null, null);
                throw new Exception("Cannot authenticate with key");
            }

            if (!is_readable($key)) {
                $this->server->logCommand('Not readable private key: ' . $key, null, null, null);
                throw new Exception("Cannot authenticate with key");
            }
        }

        $auth = null;
        if ($type == 'key') {
            $auth = ssh2_auth_pubkey_file($this->connection, $user, $key . '.pub', $key, '');
        } else {
            $auth = ssh2_auth_password($this->connection, $user, $key);
        }

        /**
         * Throw exception on misconfiguration.
         */
        if (!$auth) {
            $this->server->logCommand('Cannot authenticate: ' . $type . ' ' . $user . ' ' . $key . ' ' . $host . ' ' .
                                      $port, null, null, null);
            throw new Exception("Cannot authenticate with " . $type);
        } else {
            $this->server->logCommand('Authenticated with SSH', null, null, null);
        }
    }

    public function getConnectionConfig()
    {
        return [
            'host' => $this->host,
            'port' => $this->port,
            'user' => $this->user,
            'key'  => $this->key,
        ];
    }

    /**
     * @return Server
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * @param      $commands
     * @param null $errorStreamContent
     * @param null $dir
     *
     * @return $this
     */
    public function execMultiple($commands, &$output = null, &$error = null, $dir = null)
    {
        if (!$commands) {
            return $this;
        }

        foreach ($commands as $command) {
            if ($dir) {
                $command = 'cd ' . $dir . ' && ' . $command;
            }
            $this->exec($command, $output, $error);
        }

        return $this;
    }

    /**
     * @param      $command
     * @param null $output
     * @param null $error
     *
     * @return bool|mixed|null|string
     */
    public function exec($command, &$output = null, &$error = null)
    {
        $e = null;
        $infoStreamContent = null;
        $errorStreamContent = null;
        $serverCommand = $this->server->logCommand('Executing command ' . $command, null, null, null);
        try {
            $stream = ssh2_exec($this->connection, $command);

            $errorStream = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);

            stream_set_blocking($errorStream, true);
            stream_set_blocking($stream, true);

            $errorStreamContent = stream_get_contents($errorStream);
            $infoStreamContent = stream_get_contents($stream);
        } catch (Throwable $e) {
            d(exception($e));
            $serverCommand->setAndSave([
                                           'command' => 'Error executing command ' . $command,
                                           'info'    => $infoStreamContent,
                                           'error'   => $errorStreamContent,
                                       ]);

            return null;
        } finally {
            $output = $infoStreamContent;
            $error = $errorStreamContent;

            d($command, $output, $error);

            $serverCommand->setAndSave([
                                           'command' => 'Command executed ' . $command,
                                           'info'    => $infoStreamContent,
                                           'error'   => $errorStreamContent,
                                           'code'    => 1,
                                       ]);
        }

        return $infoStreamContent;
    }

    /**
     * @param        $dir
     * @param string $group
     * @param string $permissions
     */
    public function makeAndAllow($dir, $group = 'www-data', $permissions = 'g+rwx')
    {
        $this->exec('mkdir -p ' . $dir);
        $this->exec('chown www-data:www-data ' . $dir);
        $this->exec('chgrp ' . $group . ' ' . $dir);
        $this->exec('chmod ' . $permissions . ' ' . $dir);
    }

    /**
     *
     */
    public function open()
    {

    }

    /**
     * @return $this
     */
    public function close()
    {
        if ($this->connection) {
            $this->server->logCommand('Closing connection', null, null, null);

            ssh2_exec($this->connection, 'exit');
            unset($this->connection);
        }

        return $this;
    }

    /**
     * @param $file
     *
     * @return bool|string
     * @throws Exception
     */
    public function sftpRead($file)
    {
        /*return '[client]
password = s0m3p4ssw0rd';*/

        $this->server->logCommand('Reading remote ' . $file, null, null, null);

        $sftp = $this->openSftp();

        $stream = @fopen("ssh2.sftp://" . intval($sftp) . $file, 'r');

        if (!$stream) {
            throw new Exception('Cannot open stream');
        }

        $tmp = '/tmp/' . sha1(microtime());
        if (!$localStream = @fopen($tmp, 'w')) {
            throw new Exception('Unable to open local file for writing: ' . $tmp);
        }

        $read = 0;
        $fileSize = filesize('ssh2.sftp://' . intval($sftp) . $file);
        while ($read < $fileSize && ($buffer = fread($stream, $fileSize - $read))) {
            $read += strlen($buffer);

            if (fwrite($localStream, $buffer) === false) {
                throw new Exception('Unable to write to local file: ' . $tmp);
            }
        }

        fclose($localStream);
        fclose($stream);

        $content = file_get_contents($tmp);
        unlink($tmp);

        return $content;
    }

    /**
     * @return null|resource
     */
    protected function openSftp()
    {
        if (!$this->ssh2Sftp) {
            $this->ssh2Sftp = ssh2_sftp($this->connection);
        }

        return $this->ssh2Sftp;
    }

    /**
     * @return int
     */
    public function tunnel()
    {
        if (!$this->tunnel) {
            $this->server->logCommand('Creating SSH tunnel', null, null, null);
            /**
             * Create SSH tunnel.
             * -p 22222 - connect via ssh on port 22222
             * -f - for connection, send it to background
             * -L localPort:ip:remotePort - local forwarding (-R - opposite, remote forwarding)
             * -g ?
             *
             * This allows connection on a localhost to tunnelPort.
             * For example, impero can connect directly to zero's db.
             * Now we would like to reuse this to connect to a container on zero?
             */
            $this->tunnelPort = 3307; // @T00D00
            $command = 'ssh -p ' . $this->port . ' -i ' . $this->key . ' -f -L ' . $this->tunnelPort .
                ':127.0.0.1:3306 ' . $this->user . '@' . $this->host . ' sleep 10 >> /tmp/tunnel.' . $this->host . '.' .
                $this->port . '.log';
            shell_exec($command);
        }

        return $this->tunnelPort;
    }

    /**
     * @param $dir
     *
     * @return bool
     */
    public function dirExists($dir)
    {
        $sftp = $this->openSftp();

        return is_dir("ssh2.sftp://" . intval($sftp) . $dir);
    }

    /**
     * @param $dir
     * @param $mode
     * @param $recursive
     *
     * @return bool
     */
    public function createDir($dir, $mode, $recursive)
    {
        $sftp = $this->openSftp();
        $this->server->logCommand('Creating dir ' . $dir);

        return ssh2_sftp_mkdir($sftp, $dir, $mode, $recursive);
    }

    public function deleteFile($file, $sudo = false)
    {
        if ($sudo) {
            return $this->exec('sudo rm ' . $file);
        }

        $sftp = $this->openSftp();

        return ssh2_sftp_unlink($sftp, $file);
    }

    public function deleteDir($dir, $sudo = false)
    {
        if ($sudo) {
            return $this->exec('sudo rm -r ' . $dir);
        }

        $sftp = $this->openSftp();

        return ssh2_sftp_rmdir($sftp, $dir);
    }

    /**
     * @param $file
     *
     * @return bool
     */
    public function fileExists($file)
    {
        $sftp = $this->openSftp();

        return file_exists("ssh2.sftp://" . intval($sftp) . $file) && !is_dir("ssh2.sftp://" . intval($sftp) . $file);
    }

    /**
     * @param $symlink
     *
     * @return bool
     */
    public function symlinkExists($symlink)
    {
        $sftp = $this->openSftp();

        return is_link("ssh2.sftp://" . intval($sftp) . $symlink);
    }

    /**
     * @param        $file
     * @param Server $to
     *
     * @throws Exception
     */
    public function rsyncCopyTo($file, Server $to)
    {
        $dir = implode('/', array_slice(explode('/', $file), 0, -1));
        if (!$to->getConnection()->dirExists($dir)) {
            $to->getConnection()->exec('mkdir -p ' . $dir);
        }
        $this->exec('rsync -a ' . $file . ' impero@' . $to->privateIp . ':' . $file . ' -e \'ssh -p ' . $to->port .
                    '\'');
    }

    /**
     * @param             $file
     * @param Server|null $from
     */
    public function rsyncCopyFrom($file, Server $from = null)
    {
        if (!$from) {
            /**
             * We are copying for example some file from impero to $this connection.
             */
            $command = 'rsync -a ' . $file . ' impero@' . $this->host . ':' . $file . ' -e \'ssh -p ' . $this->port .
                '\'';

            /**
             * @T00D00 ... how to do this transparent?
             *         ... how to use different port?
             */
            exec($command);

            return;
        }
        /**
         * We are copying for example some file from $this connection to remote $from
         */
        $command = 'rsync -a impero@' . $from->privateIp . ':' . $file . ' ' . $file . ' -e \'ssh -p ' . $from->port .
            '\'';
        $this->exec($command);
    }

    /**
     * @param $file
     * @param $content
     */
    public function saveContent($file, $content)
    {
        /**
         * Save content to temporary file.
         */
        $tmp = tempnam('/tmp', 'tmp');
        $this->server->logCommand('Saving content to ' . $tmp);
        file_put_contents($tmp, $content);

        /**
         * Send file to remote server.
         */
        $this->server->logCommand('Sending content to ' . $file);
        $this->sftpSend($tmp, $file);

        /**
         * Remove temporary file.
         */
        $this->server->logCommand('Removing ' . $tmp);
        unlink($tmp);
    }

    /**
     * @param      $local
     * @param      $remote
     * @param null $mode
     * @param bool $isFile
     *
     * @return bool
     */
    public function sftpSend($local, $remote, $mode = null, $isFile = true)
    {
        $this->server->logCommand('Copying local ' . $local . ' to remote ' . $remote, null, null, null);

        $sftp = $this->openSftp();

        $stream = fopen("ssh2.sftp://" . intval($sftp) . $remote, '+w');

        $ok = @fwrite($stream, $isFile ? file_get_contents($local) : $local);

        @fclose($stream);

        return !!$ok;
    }

    /**
     * @return ConnectionInterface
     */
    public function getConnection() : SshConnection
    {
        return $this;
    }

    public function sendFileTo($local, $remote, Server $to)
    {
        try {
            $to->getConnection()->sftpSend($local, $remote);
        } catch (\Throwable $e) {
            ddd(exception($e));
        }
    }

}
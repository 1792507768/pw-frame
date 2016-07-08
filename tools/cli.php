<?php
/**
 * 构建工具脚本
 * @author Ouyang <iisquare@163.com>
 *
 */
class CliUtil {
    
    const TIPS_FAILED = 'failed';
    const TIPS_SUCCESS = 'ok';
    
    public static function copydir($sourceDir, $destDir, callable $callback = null) {
        if(!file_exists($sourceDir) || !is_dir($sourceDir)) {
            self::printMessage($sourceDir.' is not a directory');
            return false;
        }
        if(!file_exists($destDir) || !is_dir($destDir)) {
            self::printMessage($destDir.' is not a directory');
            return false;
        }
        $result = true;
        $dir = opendir($sourceDir);
		if(!$dir) {
			self::printMessage($sourceDir.' can not be open');
			return false;
		}
        while (false !== ($sourceName = readdir($dir))) {
            if(in_array($sourceName, ['.', '..'])) continue ;
            $destName = $callback ? $callback($sourceName) : $sourceName;
            if(is_dir($sourceDir.DS.$sourceName)) {
                if(is_file($destDir.DS.$destName)) {
                    $result = false;
                    self::printMessage('ERROR:'.$destDir.DS.$destName.' maybe a directory, but is a file!');
                    break;
                }
                if(!file_exists($destDir.DS.$destName)) {
                    self::printMessage('[mkdir]'.$destDir.DS.$destName.' - '
                        .(mkdir($destDir.DS.$destName) ? self::TIPS_SUCCESS : self::TIPS_FAILED));
                }
                $result &= self::copydir($sourceDir.DS.$sourceName, $destDir.DS.$destName, $callback);
            } else {
                if(file_exists($destDir.DS.$destName)) {
                    self::printMessage('[exists]'.$destDir.DS.$destName);
                } else {
                    self::printMessage('[copy]'.$destDir.DS.$destName.' - '
                        .(copy($sourceDir.DS.$sourceName, $destDir.DS.$destName) ? self::TIPS_SUCCESS : self::TIPS_FAILED));
                }
            }
        }
        closedir($dir);
        return $result;
    }
    
    public static function rmdir($dirName) {
		if(!file_exists($dirName)) return true;
		if(!is_dir($dirName)) {
            self::printMessage($dirName.' is not a directory');
            return false;
        }
		$result = true;
		$dir = opendir($dirName);
		if(!$dir) {
			self::printMessage($dirName.' can not be open');
			return false;
		}
		while (false !== ($fileName = readdir($dir))) {
            if(in_array($fileName, ['.', '..'])) continue ;
            if(is_dir($dirName.DS.$fileName)) {
                $result &= self::rmdir($dirName.DS.$fileName);
            } else {
                $result &= self::unlink($dirName.DS.$fileName);
            }
        }
		closedir($dir);
        self::printMessage('[rmdir]'.$dirName.' - '.(rmdir($dirName) ? self::TIPS_SUCCESS : self::TIPS_FAILED));
        return $result;
    }
    
    public static function unlink($fileName) {
		if(!file_exists($fileName)) return true;
		if(!is_file($fileName)) {
			self::printMessage($fileName.' is not a file');
			return false;
		}
        $result = unlink($fileName);
        self::printMessage('[unlink]'.$fileName.' - '.($result ? self::TIPS_SUCCESS : self::TIPS_FAILED));
        return $result;
    }
    
    public static function printResult($result) {
        self::printMessage($result ? 'total ok!' : 'something error!');
    }
    
    public static function printMessage($message, $isBreak = true) {
        echo $message;
        if($isBreak) echo "\r\n";
    }
    
}
$projectDir = dirname(dirname(__FILE__));
define('DS', DIRECTORY_SEPARATOR);
CliUtil::printMessage('--------------------------------------------------------');
switch ($argv[1]) {
    case 'eclipse' :
        $result = CliUtil::copydir($projectDir.DS.'tools'.DS.'eclipse', $projectDir, function ($fileName) {
            if(0 === strpos($fileName, 'dot.'));
            $fileName = substr($fileName, 3);
            return $fileName;
        });
        CliUtil::printResult($result);
        break;
    case 'cleanEclipse' :
        $result = true;
        $dirNames = ['.settings'];
        foreach ($dirNames as $dirName) {
            $result &= CliUtil::rmdir($projectDir.DS.$dirName);
        }
        $fileNames = ['.buildpath', '.project'];
        foreach ($fileNames as $fileName) {
            $result &= CliUtil::unlink($projectDir.DS.$fileName);
        }
        CliUtil::printResult($result);
        break;
    case 'help' :
    default :
        CliUtil::printMessage('command reference:');
        CliUtil::printMessage('  eclipse - copy Eclipse IDE files');
        CliUtil::printMessage('  cleanEclipse - clean Eclipse IDE files');
}
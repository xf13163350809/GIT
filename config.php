<?php
return array(
        'web_path'=>realpath("./"),    //��Ŀ����·��

        /* ���ݿ����� */
        'DB'=>array(
            'DB_TYPE'               =>  'pdo',     // ���ݿ�����
            'DB_HOST'               =>  '127.0.0.1', // ��������ַ
            'DB_NAME'               =>  'juhui',      // ���ݿ���
            'DB_USER'               =>  'root',      // �û���
            'DB_PWD'                =>  'root',          // ����
            'DB_PORT'               =>  '',        // �˿�
            'DB_PREFIX'             =>  'jh51_',    // ���ݿ��ǰ׺
            'DB_charset'            =>  '',     //���ݿ����(Ĭ��utf8)
            'DB_mode'               =>  '',
        ),

       /*����*/
        'cache'=>array(
            'cachePath'             =>'file',    //����洢·��
            'cacheTime'             =>'60',     //����ʱ��(0Ϊ����)��
            'cacheFileType'         =>'.txt',     //�����ļ���׺
        ),

        /*�쳣����*/
        'debug'=>array(
            'IGNORE_EXCEPTION'      =>'TRUE'    //�Ƿ���ʾ������Ϣ��TRUE OR FALSE��
        ),

    );
?>
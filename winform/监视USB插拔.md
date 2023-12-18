```
protected override void WndProc(ref Message message)
{
    const int WM_DEVICECHANGE = 0x219; //设备改变
    const int DBT_DEVICEARRIVAL = 0x8000; //检测到新设备
    const int DBT_DEVICEREMOVECOMPLETE = 0x8004; //移除设备

    base.WndProc(ref message);//调用父类方法，以确保其他功能正常
    if (message.Msg == WM_DEVICECHANGE) 
    {
        int wParam = (int)message.WParam;
        if (wParam == DBT_DEVICEARRIVAL)
        {
            int devType = Marshal.ReadInt32(message.LParam, 4);
            //设备新增类型
        }
        else if (wParam == DBT_DEVICEREMOVECOMPLETE)
        {
            //设备移除
        }
        else 
        {
            //设备事件
        }
    }
}
```

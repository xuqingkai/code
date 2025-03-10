## 同步
```
private void Test()
{
    this.Invoke(new Action(() =>
    {
        this.Text = "100";
        Console.WriteLine("委托执行完成");
        Thread.Sleep(1000);
    }));

    Console.WriteLine("Test方法执行完成");
}
Task.Run(Test);
```
## 异步
```
private void Test()
{
    this.BeginInvoke(new Action(() =>
    {
        this.Text = "100";
        Console.WriteLine("委托执行完成");
        Thread.Sleep(1000);
    }));

    Console.WriteLine("Test方法执行完成");
}
Task.Run(Test);
```

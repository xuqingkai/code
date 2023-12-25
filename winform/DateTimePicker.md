
### 设置DateTimePicker初始值为空
```
dateTimePicker1.Format = DateTimePickerFormat.Custom; //这两项目可以在设计器里直接设置，不一定用代码
dateTimePicker1.CustomFormat=" "; //注意这里必须是空格
dateTimePicker1.ValueChanged += new EventHandler(delegate (object sender, EventArgs e)
{
  DateTimePicker dateTimePicker = (DateTimePicker)sender;
  dateTimePicker.CustomFormat = dateTimePicker.Checked ? "yyyy-MM-dd" : null;
});
```

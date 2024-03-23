using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Windows.Forms;

namespace Client
{
    public partial class FormImage : Form
    {
        public FormImage()
        {
            InitializeComponent();
        }

        private int xPos;

        private int yPos;

        public FormImage(Image image)
        {
            InitializeComponent();
            this.ActiveControl = pictureBox;
            //this.WindowState = FormWindowState.Maximized;

            pictureBox.Image = image;
            pictureBox.Dock = DockStyle.None;
            pictureBox.SizeMode = PictureBoxSizeMode.Zoom;
            pictureBox.Width = this.Width;
            pictureBox.Height = this.Height;

            pictureBox.MouseWheel += new MouseEventHandler(delegate (object sender, MouseEventArgs e)
            {
                int width = pictureBox.Width;
                int height = pictureBox.Height;

                if (e.Delta > 0)
                {
                    pictureBox.Width = (int)(pictureBox.Width * 1.1);
                    pictureBox.Height = (int)(pictureBox.Height * 1.1);
                }
                else
                {
                    pictureBox.Width = (int)(pictureBox.Width * 0.9);
                    pictureBox.Height = (int)(pictureBox.Height * 0.9);
                }

                Point location = new Point();
                location.X = pictureBox.Location.X - (pictureBox.Width - width) / 2;
                location.Y = pictureBox.Location.Y - (pictureBox.Height - height) / 2;
                pictureBox.Location = location;
            });
            pictureBox.MouseDown += new MouseEventHandler(delegate (object sender, MouseEventArgs e)
            {
                xPos = e.X;//当前x坐标.
                yPos = e.Y;//当前y坐标.

            });
            pictureBox.MouseMove += new MouseEventHandler(delegate (object sender, MouseEventArgs e)
            {
                try
                {
                    // 鼠标按下拖拽图片
                    if (e.Button == MouseButtons.Left || e.Button == MouseButtons.Right)
                    {
                        pictureBox.Left += Convert.ToInt32(e.X - xPos);//设置x坐标.
                        pictureBox.Top += Convert.ToInt32(e.Y - yPos);//设置y坐标.
                    }
                }
                catch (Exception dd)
                {
                    MessageBox.Show(dd.Message);
                }
            });
        }

        private void pictureBox_DoubleClick(object sender, EventArgs e)
        {
            this.Close();
            this.Dispose();
        }

        private void Form_KeyDown(object sender, KeyEventArgs e)
        {
            if (e.KeyData == Keys.Escape) 
            {
                this.Close();
            } 
        }

        private void FormImage_Resize(object sender, EventArgs e)
        {
            this.Text = this.Width.ToString();
            pictureBox.Width = this.Width;
            pictureBox.Height = this.Height;
        }
    }
}

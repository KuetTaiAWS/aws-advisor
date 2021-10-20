Login to AWS Console with the permission to
- readOnly permission for required services
- CloudShell

In CloudShell terminal, run this to install php:
```bash
if(sudo yum list installed  | grep php-cli > /dev/null) then echo 'PHP installed ,skipped'; else sudo amazon-linux-extras install -y php7.2; fi
##aws-sdk required mbstring
if(sudo yum list installed | grep php-mbstring > /dev/null) then echo 'php-mbstring installed, skipped'; else sudo yum install php-mbstring -y; fi
git clone git@github.com:cykhoo0108/aws-advisor.git
cd aws-advisor
alias advisor='php $(pwd)/advise.php'
advisor --region ap-southeast-1
```
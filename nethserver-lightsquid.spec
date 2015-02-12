Summary: NethServer web access statistics
Name: nethserver-lightsquid
Version: 1.0.2
Release: 1
License: GPL
Source: %{name}-%{version}.tar.gz
BuildArch: noarch
URL: https://dev.nethesis.it/projects/%{name}

BuildRequires: nethserver-devtools

AutoReq: no
Requires: nethserver-httpd
Requires: nethserver-squid
Requires: lightsquid, lightsquid-apache

%description
NethServer web access statistics
See: http://lightsquid.sourceforge.net/

%prep
%setup

%post

%preun

%build
perl createlinks

%install
rm -rf $RPM_BUILD_ROOT
(cd root   ; find . -depth -print | cpio -dump $RPM_BUILD_ROOT)

%{genfilelist} $RPM_BUILD_ROOT > e-smith-%{version}-filelist
echo "%doc COPYING"          >> e-smith-%{version}-filelist

%clean 
rm -rf $RPM_BUILD_ROOT

%files -f e-smith-%{version}-filelist
%defattr(-,root,root)

%changelog
* Tue Jul 16 2013 Giacomo Sanchietti <giacomo.sanchietti@nethesis.it> - 1.0.2-1.ns6
- Add lightsquid-apache dependency #1962

* Tue Jul 16 2013 Giacomo Sanchietti <giacomo.sanchietti@nethesis.it> - 1.0.1-1.ns6
- Add lightsquid dependency #1962

* Fri Jun 21 2013 Giacomo Sanchietti <giacomo.sanchietti@nethesis.it> - 1.0.0-1.ns6
- First release. Feature #1962
